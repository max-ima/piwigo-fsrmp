<?php
defined('FSRMP_PATH') or die('Hacking attempt!');

/**
 * admin plugins menu link
 */
function fsrmp_get_admin_plugin_menu_links($menu)
{
  $menu[] = array(
    'NAME' => l10n('Fsrmp'),
    'URL' => FSRMP_ADMIN,
    );

  return $menu;
}

function fsrmp_get_batch_manager_prefilters($prefilters)
{
	global $conf;
  
	$prefilters[] = array(
		'ID' => 'fsrmp1', 
		'NAME' => l10n('Modified since less than %d %s', $conf['fsrmp']['nb1'], l10n($conf['fsrmp']['unit1']).((1<$conf['fsrmp']['nb1'])?'s':'') )
	);
	$prefilters[] = array(
		'ID' => 'fsrmp2', 
		'NAME' => l10n('Modified since less than %d %s', $conf['fsrmp']['nb2'], l10n($conf['fsrmp']['unit2']).((1<$conf['fsrmp']['nb2'])?'s':'') )
	);
	return $prefilters;
}

function fsrmp_perform_batch_manager_prefilters($filter_sets, $prefilter)
{
	global $conf;
  
	if ($prefilter==="fsrmp1") {
// 			$filter = "-mmin -60";
		$filter = sprintf('-%s -%d', $conf['fsrmp']['unit1'], $conf['fsrmp']['nb1']);
	}
	else if ($prefilter==="fsrmp2") {
// 			$filter = "-mtime -1";
		$filter = sprintf('-%s -%d', $conf['fsrmp']['unit2'], $conf['fsrmp']['nb2']);
	}
		
	$cmd = 'find -L '.PHPWG_ROOT_PATH.'galleries'.' -type f '.$filter.'' ;
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

