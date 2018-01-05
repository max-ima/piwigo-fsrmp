<?php
defined('FSRMP_PATH') or die('Hacking attempt!');

// +-----------------------------------------------------------------------+
// | Home tab                                                              |
// +-----------------------------------------------------------------------+

// send variables to template
$template->assign(array(
  'fsrmp' => $conf['fsrmp'],
  'INTRO_CONTENT' => load_language('intro.html', FSRMP_PATH, array('return'=>true)),
  ));

// define template file
$template->set_filename('fsrmp_content', realpath(FSRMP_PATH . 'admin/template/home.tpl'));
