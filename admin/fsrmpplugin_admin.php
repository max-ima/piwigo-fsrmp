<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
 
$me = get_plugin_data($plugin_id);
 
if (isset($_POST['submit']))
{
	if(preg_match('/^[0-9]+$/', $_POST['FSRMPPLUGIN_VAR1D'])) {
		$me->my_config['FsrmpPlugin1d'] = $_POST['FSRMPPLUGIN_VAR1D'];
	}
	if(preg_match('/^[0-9]+$/', $_POST['FSRMPPLUGIN_VAR2D'])) {
		$me->my_config['FsrmpPlugin2d'] = $_POST['FSRMPPLUGIN_VAR2D'];
	}
	if(preg_match('/^(mmin|mtime)$/', $_POST['FSRMPPLUGIN_VAR1U'])) {
		$me->my_config['FsrmpPlugin1u'] = $_POST['FSRMPPLUGIN_VAR1U'];
	}
	if(preg_match('/^(mmin|mtime)$/', $_POST['FSRMPPLUGIN_VAR2U'])) {
		$me->my_config['FsrmpPlugin2u'] = $_POST['FSRMPPLUGIN_VAR2U'];
	}
	$me->save_config();
}
 
global $template;
$template->set_filenames( array('plugin_admin_content' => dirname(__FILE__).'/fsrmpplugin_admin.tpl') );
 
$template->assign('myOptions', array('mmin' => 'min', 'mtime' => 'day'));

$template->assign('FSRMPPLUGIN_VAR1D', $me->my_config['FsrmpPlugin1d']);
$template->assign('mySelect1', $me->my_config['FsrmpPlugin1u']);

$template->assign('FSRMPPLUGIN_VAR2D', $me->my_config['FsrmpPlugin2d']);
$template->assign('mySelect2', $me->my_config['FsrmpPlugin2u']);
 
$template->assign_var_from_handle( 'ADMIN_CONTENT', 'plugin_admin_content');
?> 
