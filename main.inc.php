<?php
/*
Plugin Name: Filtre fsrmp
Version: 1.2.4
Description: Adds filters to batch manager in order to retrieve OS recently modified pictures
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=870
Author: TOnin
Author URI: https://github.com/7tonin
Has Settings: true
*/

/**
 * This is the main file of the plugin, called by Piwigo in "include/common.inc.php" line 137.
 * At this point of the code, Piwigo is not completely initialized, so nothing should be done directly
 * except define constants and event handlers (see http://piwigo.org/doc/doku.php?id=dev:plugins)
 */

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');


// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+
global $prefixeTable;

define('FSRMP_ID',      basename(dirname(__FILE__)));
define('FSRMP_PATH' ,   PHPWG_PLUGINS_PATH . FSRMP_ID . '/');
define('FSRMP_TABLE',   $prefixeTable . 'fsrmp');
define('FSRMP_ADMIN',   get_root_url() . 'admin.php?page=plugin-' . FSRMP_ID);
define('FSRMP_PUBLIC',  get_absolute_root_url() . make_index_url(array('section' => 'fsrmp')) . '/');
define('FSRMP_DIR',     PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'fsrmp/');



// +-----------------------------------------------------------------------+
// | Add event handlers                                                    |
// +-----------------------------------------------------------------------+
// init the plugin
add_event_handler('init', 'fsrmp_init');

/*
 * this is the common way to define event functions: create a new function for each event you want to handle
 */
if (defined('IN_ADMIN'))
{
	// file containing all admin handlers functions
	$admin_file = FSRMP_PATH . 'include/admin_events.inc.php';
	
	// Hook on to an event to show the administration page.
	add_event_handler('get_admin_plugin_menu_links', 'fsrmp_get_admin_plugin_menu_links',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

	// Hook to add a new filter in the batch mode
	add_event_handler('get_batch_manager_prefilters', 'fsrmp_get_batch_manager_prefilters',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

	// Hook to perfom the filter in the batch mode
	add_event_handler('perform_batch_manager_prefilters', 'fsrmp_perform_batch_manager_prefilters',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

	// Hook to store date-time if metadata action batch mode
	add_event_handler('element_set_global_action', 'fsrmp_element_set_global_action',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
}


/**
 * plugin initialization
 *   - check for upgrades
 *   - unserialize configuration
 *   - load language
 */
function fsrmp_init()
{
  global $conf;

  // load plugin language file
  load_language('plugin.lang', FSRMP_PATH);

  // prepare plugin configuration
  $conf['fsrmp'] = safe_unserialize($conf['fsrmp']);
}
