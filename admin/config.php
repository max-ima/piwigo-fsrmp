<?php
defined('FSRMP_PATH') or die('Hacking attempt!');

// +-----------------------------------------------------------------------+
// | Configuration tab                                                     |
// +-----------------------------------------------------------------------+

// save config
if (isset($_POST['save_config']))
{
	if(preg_match('/^[1-9][0-9]{0,3}$/', $_POST['FSRMPPLUGIN_VAR_NB1'])) {
		$conf['fsrmp']['nb1'] = $_POST['FSRMPPLUGIN_VAR_NB1'];
	}
	if(preg_match('/^[1-9][0-9]{0,3}$/', $_POST['FSRMPPLUGIN_VAR_NB2'])) {
		$conf['fsrmp']['nb2'] = $_POST['FSRMPPLUGIN_VAR_NB2'];
	}
	if(preg_match('/^(mmin|mtime)$/', $_POST['FSRMPPLUGIN_VAR_UNIT1'])) {
		$conf['fsrmp']['unit1'] = $_POST['FSRMPPLUGIN_VAR_UNIT1'];
	}
	if(preg_match('/^(mmin|mtime)$/', $_POST['FSRMPPLUGIN_VAR_UNIT2'])) {
		$conf['fsrmp']['unit2'] = $_POST['FSRMPPLUGIN_VAR_UNIT2'];
	}
	if(isset($_POST['FSRMPPLUGIN_VAR_ENABLED_FILTERS']) && is_array($_POST['FSRMPPLUGIN_VAR_ENABLED_FILTERS'])) {
		$conf['fsrmp']['enabled_filters'] = array();
		foreach($_POST['FSRMPPLUGIN_VAR_ENABLED_FILTERS'] as $key => $val) {
			if(preg_match('/^(f1|f2|f3)$/', $val)) {
				$conf['fsrmp']['enabled_filters'][] = $val;
			}
		}
	}
	else {
		$conf['fsrmp']['enabled_filters'] = array();
	}

	conf_update_param('fsrmp', $conf['fsrmp']);
	$page['infos'][] = l10n('Information data registered in database');
}

$select_options = array(
  'mmin' => l10n('mmin'),
  'mtime' => l10n('mtime'),
  );

// send config to template
include_once(FSRMP_PATH . 'include/admin_events.inc.php');
$template->assign(array(
  'fsrmp' => $conf['fsrmp'],
  'fsrmp_bm_mmin' => fsrmp_duration(),
  'fsrmp_bm_mtime' => fsrmp_duration('mtime'),
  'select_options' => $select_options
  ));

// define template file
$template->set_filename('fsrmp_content', realpath(FSRMP_PATH . 'admin/template/config.tpl'));
