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
  
	if (in_array('f1', $conf['fsrmp']['enabled_filters'])) {
		$prefilters[] = array(
			'ID' => 'fsrmp1', 
			'NAME' => l10n('Modified since less than %d %s', $conf['fsrmp']['nb1'], l10n($conf['fsrmp']['unit1']).((1<$conf['fsrmp']['nb1'])?'s':'') )
		);
	}
	if (in_array('f2', $conf['fsrmp']['enabled_filters'])) {
		$prefilters[] = array(
			'ID' => 'fsrmp2', 
			'NAME' => l10n('Modified since less than %d %s', $conf['fsrmp']['nb2'], l10n($conf['fsrmp']['unit2']).((1<$conf['fsrmp']['nb2'])?'s':'') )
		);
	}
	if (in_array('f3', $conf['fsrmp']['enabled_filters'])) {
		$prefilters[] = array(
			'ID' => 'fsrmp3', 
			'NAME' => l10n('Modified since previous bm.metadata (%d files), since less than about %d %s', 
				$conf['fsrmp']['batch_manager_metadata']['nb'],
				fsrmp_duration(), 
				l10n('mmin').'s'
			)
		);
	}
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
	else if ($prefilter==="fsrmp3") {
// 			$filter = "-mmin -16573";
		$filter = sprintf('-%s -%d', 'mmin', fsrmp_duration());
	}
		
	if(isset($filter)) {
		$cmd = 'find -L '.PHPWG_ROOT_PATH.'galleries'.' -type f '.$filter.'' ;
		if(exec($cmd, $output)) {
			$list = $output ;
		}
		else {
			$list = array() ;
		}
		
		$list_f = array_map('pwg_db_real_escape_string', array_map('basename', array_map('fsrmp_pr2video', $list))) ;
		$in_list = "('".implode("', '", $list_f)."')" ;
		
		if ( !empty($list_f) )
		{
			$query = "SELECT id FROM ".IMAGES_TABLE." WHERE file IN ".$in_list;
			$filter_sets[] = array_from_query($query, 'id');
		}
	}
	return $filter_sets;
}

/*
string $action : 'metadata'
array $collection : array (0 => '94094', 1 => '92953', ... , 18 => '64904', 19 => '64903', ),
*/
function fsrmp_element_set_global_action($action, $collection) {
	global $conf;

	if('metadata'==$action) {
		$conf['fsrmp']['batch_manager_metadata']['latest'] = time();
		$conf['fsrmp']['batch_manager_metadata']['pictures_nb'] = count($collection);
		conf_update_param('fsrmp', $conf['fsrmp']);
	}
}

/*
Returns duration since latest bm.metadata update. Default unit is minute, but if 'mtime' is given it's day. 
string $interval : 'mmin' ou 'mtime' (minutes or days)
*/
function fsrmp_duration($interval = 'mmin') {
	global $conf;
	switch($interval) {
	case 'mmin' : $seconds_interval = 60 ; break ;
	case 'mtime' : $seconds_interval = 86400 ; break ;
	default : $seconds_interval = 60 ; 
	}
	// one more second to make sure no file will be forgotten
	return ceil((1+time()-$conf['fsrmp']['batch_manager_metadata']['latest'])/$seconds_interval) ;
}

/*
Detects if the file is a pwg_representative of a video
Try to return video file path
string $file : '/absolute/path/to/file'
*/
function fsrmp_pr2video($file) {
	if(in_array(substr($file, -7), array('_lq.jpg', '_hq.jpg')) && 'pwg_representative'==basename(dirname($file))) {
		foreach(array('avi', '3gp', 'mov') as $ext) {
			if (file_exists(dirname(dirname($file)).'/'.substr(basename($file), 0, -7).'.'.$ext)) {
				return dirname(dirname($file)).'/'.substr(basename($file), 0, -7).'.'.$ext ;
			}
		}
	}
	return $file ;
}
