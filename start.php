<?php

/**
 * hypeObserver
 *
 * Observer Dashboards
 * @package hypeJunction
 * @subpackage hypeObserver
 *
 * @author Ismayil Khayredinov <ismayil.khayredinov@gmail.com>
 * @copyright Copyright (c) 2011-2013, Ismayil Khayredinov
 */

define('HYPEOBSERVER_RELEASE', 1374851653);

// Restrict access to non-public pages and actions
define('HYPEOBSERVER_RESTRICTED_ACCESS', elgg_get_plugin_setting('restricted_access', 'hypeObserver'));

// Ignore river access levels for content owned or contained by observed users
define('HYPEOBSERVER_IGNORE_RIVER_ACCESS', elgg_get_plugin_setting('ignore_river_access', 'hypeObserver'));

define('HYPEOBSERVER_INBOX_ACCESS', elgg_get_plugin_setting('inbox_access', 'hypeObserver'));
define('HYPEOBSERVER_OUTBOX_ACCESS', elgg_get_plugin_setting('outbox_access', 'hypeObserver'));
define('HYPEOBSERVER_ANNOTATIONS_ACCESS', elgg_get_plugin_setting('annotations_access', 'hypeObserver'));


$object_subtypes = elgg_get_plugin_setting('object_subtypes', 'hypeObserver');
if ($object_subtypes) {
	elgg_set_config('observer_object_subtypes', unserialize($object_subtypes));
}


elgg_register_event_handler('init', 'system', 'hj_observer_init');

function hj_observer_init() {

	elgg_register_event_handler('upgrade', 'system', 'hj_observer_check_release');

	$path = elgg_get_plugins_path() . 'hypeObserver/';
	
	$libraries = array(
		'base',
		'events',
		'assets',
		'page_handlers',
		'actions',
		'views',
		'menus',
		'hooks'
	);

	foreach ($libraries as $lib) {
		$libpath = "{$path}lib/{$lib}.php";
		if (file_exists($libpath)) {
			elgg_register_library("observer:library:$lib", $libpath);
			elgg_load_library("observer:library:$lib");
		}
	}

}

/**
 * Perform plugin upgrades upon release change
 */
function hj_observer_check_release($event, $type, $params) {

	if (!elgg_is_admin_logged_in()) {
		return true;
	}

	$release = HYPEOBSERVER_RELEASE;
	$old_release = elgg_get_plugin_setting('release', 'hypeObserver');

	if ($release > $old_release) {

		elgg_register_library("observer:library:upgrade", elgg_get_plugins_path() . 'hypeObserver/lib/upgrade.php');
		elgg_load_library("observer:library:upgrade");

		elgg_set_plugin_setting('release', $release, 'hypeObserver');
	}

	return true;
}
