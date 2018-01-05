<?php
defined('FSRMP_PATH') or die('Hacking attempt!');

// +-----------------------------------------------------------------------+
// | Configuration tab                                                     |
// +-----------------------------------------------------------------------+

// save config
if (isset($_POST['save_config']))
{
	if(preg_match('/^[0-9]+$/', $_POST['FSRMPPLUGIN_VAR_NB1'])) {
		$conf['fsrmp']['nb1'] = $_POST['FSRMPPLUGIN_VAR_NB1'];
	}
	if(preg_match('/^[0-9]+$/', $_POST['FSRMPPLUGIN_VAR_NB2'])) {
		$conf['fsrmp']['nb2'] = $_POST['FSRMPPLUGIN_VAR_NB2'];
	}
	if(preg_match('/^(mmin|mtime)$/', $_POST['FSRMPPLUGIN_VAR_UNIT1'])) {
		$conf['fsrmp']['unit1'] = $_POST['FSRMPPLUGIN_VAR_UNIT1'];
	}
	if(preg_match('/^(mmin|mtime)$/', $_POST['FSRMPPLUGIN_VAR_UNIT2'])) {
		$conf['fsrmp']['unit2'] = $_POST['FSRMPPLUGIN_VAR_UNIT2'];
	}

	conf_update_param('fsrmp', $conf['fsrmp']);
	$page['infos'][] = l10n('Information data registered in database');
}

$select_options = array(
  'mmin' => l10n('mmin'),
  'mtime' => l10n('mtime'),
  );

// send config to template
$template->assign(array(
  'fsrmp' => $conf['fsrmp'],
  'select_options' => $select_options
  ));

// define template file
$template->set_filename('fsrmp_content', realpath(FSRMP_PATH . 'admin/template/config.tpl'));
