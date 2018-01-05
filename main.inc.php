<?php
/*
Plugin Name: FilterSystemRecentlyModifiedPictures
Version: 1.1
Description: Filter system recently modified pictures
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=870
Author: 7tonin
Author URI: https://github.com/7tonin
*/

// Check whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

class FsrmpPlugin
{
    var $my_config;
    function load_config()
    {
        $x = @file_get_contents( dirname(__FILE__).'/data.dat' );
        if ($x!==false)
        {
            $c = unserialize($x);
            // do some more tests here
            $this->my_config = $c;
        }
 
        if ( !isset($this->my_config)
            or empty($this->my_config['FsrmpPlugin1d']) )
        {
            $this->my_config['FsrmpPlugin1d'] = 60;
            $this->my_config['FsrmpPlugin1u'] = 'mmin'; // minute
            $this->my_config['FsrmpPlugin2d'] = 1;
            $this->my_config['FsrmpPlugin2u'] = 'mtime'; // day
            $this->save_config();
        }
    }
    function save_config()
    {
        $file = fopen( dirname(__FILE__).'/data.dat', 'w' );
        fwrite($file, serialize($this->my_config) );
        fclose( $file );
    }
    function plugin_admin_menu($menu)
    {
        array_push($menu,
            array(
                'NAME' => 'Filter system recently modified pictures plugin',
                'URL' => get_admin_plugin_menu_link(dirname(__FILE__).'/admin/fsrmpplugin_admin.php')
            )
        );
        return $menu;
    }
    
	function fsrmp_get_batch_manager_prefilters($prefilters)
	{
		$prefilters[] = array(
			'ID' => 'fsrmp1', 
			'NAME' => l10n('Modified_Since').sprintf(' %d %s', $this->my_config['FsrmpPlugin1d'], $this->my_config['FsrmpPlugin1u'])
		);
		$prefilters[] = array(
			'ID' => 'fsrmp2', 
			'NAME' => l10n('Modified_Since').sprintf(' %d %s', $this->my_config['FsrmpPlugin2d'], $this->my_config['FsrmpPlugin2u'])
		);
		return $prefilters;
	}
	function fsrmp_perform_batch_manager_prefilters($filter_sets, $prefilter)
	{
		if ($prefilter==="fsrmp1") {
// 			$filter = "-mmin -60";
			$filter = sprintf('-%s -%d', $this->my_config['FsrmpPlugin1u'], $this->my_config['FsrmpPlugin1d']);
		}
		else if ($prefilter==="fsrmp2") {
// 			$filter = "-mtime -1";
			$filter = sprintf('-%s -%d', $this->my_config['FsrmpPlugin2u'], $this->my_config['FsrmpPlugin2d']);
		}
			
		$cmd = 'for f in `find -L '.PHPWG_ROOT_PATH.'galleries'.' -type f '.$filter.'`; do echo $f ; done' ;
		if(exec($cmd, $output)) {
			$list = $output ;
		}
		else {
			$list = array() ;
		}
				
		$list_f = array_map('basename', $list) ;
		$in_list = "('".implode("', '", $list_f)."')" ;
		
		if ( !empty($list_f) )
		{
			$query = "SELECT id FROM ".IMAGES_TABLE." WHERE file IN ".$in_list;
			$filter_sets[] = array_from_query($query, 'id');
		}
		return $filter_sets;
	}
}
$obj = new FsrmpPlugin();
$obj->load_config();
 
add_event_handler('get_admin_plugin_menu_links', array(&$obj, 'plugin_admin_menu') );

// Hook to add a new filter in the batch mode
add_event_handler('get_batch_manager_prefilters', array(&$obj, 'fsrmp_get_batch_manager_prefilters') );

// Hook to perfom the filter in the batch mode
add_event_handler('perform_batch_manager_prefilters', array(&$obj, 'fsrmp_perform_batch_manager_prefilters') );

set_plugin_data($plugin['id'], $obj);

?>
