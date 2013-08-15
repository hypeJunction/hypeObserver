<?php

// Give observers access only to pages where page owner is an observed user/group
elgg_register_plugin_hook_handler('output:before', 'page', 'hj_observer_restricted_access_page_gatekeeper');

// Observers can not perform any actions on the site
elgg_register_plugin_hook_handler('action', 'all', 'hj_observer_restricted_access_action_gatekeeper');

// Route activity and dashboard pages to observer dashboard
elgg_register_plugin_hook_handler('route', 'activity', 'hj_observer_route_page_handler');
elgg_register_plugin_hook_handler('route', 'dashboard', 'hj_observer_route_page_handler');

// Observer index page
elgg_register_plugin_hook_handler('index', 'system', 'hj_observer_index_page');

/**
 * Controlled access to site pages
 * In restricted access mode, observers should only have access to pages owned by observed users and groups, and their own pages
 *
 * @param string $hook Equals 'output:before'
 * @param string $type Equals 'page'
 * @param array $return An array of params for rendering the page
 * @return mixed false or modified handler/segmentes
 */
function hj_observer_restricted_access_page_gatekeeper($hook, $type, $vars) {

	if (!HYPEOBSERVER_RESTRICTED_ACCESS || !hj_observer_is_observer(elgg_get_logged_in_user_entity())) {
		return $vars;
	}

	$site = elgg_get_site_entity();
	if ($site->isPublicPage()) {
		return $vars;
	}

	$page_owner = elgg_get_page_owner_entity();

	if (!elgg_instanceof($page_owner, 'user') && !elgg_instanceof($page_owner, 'group') && !hj_observer_is_observed_user($page_owner) && !hj_observer_is_observed_group($page_owner) && $page_owner->guid != elgg_get_logged_in_user_guid()) {
		$title = elgg_echo('hj:observer:restricted_area');
		$content = elgg_echo('hj:observer:restricted_area:description');
		$vars['title'] = $title;
		$vars['sysmessages'] = null;
		$vars['body'] = elgg_view_layout('error', array(
			'title' => $title,
			'content' => $content
		));
	}

	return $vars;
}

/**
 * Controlled access to actions
 * In restricted access mode, observers should not be able to perform any actions
 *
 * @param string $hook Equals 'action'
 * @param string $action Current action name
 * @param boolean $return What other hooks says
 * @param mixed $params
 * @return boolean true|false should the action be implemented
 */
function hj_observer_restricted_access_action_gatekeeper($hook, $action, $return, $params) {

	if (!HYPEOBSERVER_RESTRICTED_ACCESS || !hj_observer_is_observer(elgg_get_logged_in_user_entity())) {
		return $return;
	}

	$site = elgg_get_site_entity();
	if ($site->isPublicPage() || $action == 'logout') {
		return $return;
	}
	
	$actions = elgg_get_config('actions');
	
	if ($actions[$action]['access'] !== 'public') {
		register_error(elgg_echo('actionunauthorized'));
		return false;
	}

	return $return;
}

/**
 * Route observer activity and dashboard pages
 *
 * @param string $hook Equals 'route'
 * @param string $handler Equals 'activity' or 'dashboard'
 * @param array $return Array of 'handler' and 'segments'
 * @return type
 */
function hj_observer_route_page_handler($hook, $handler, $return) {

	$user = elgg_get_logged_in_user_entity();
	if (!hj_observer_is_observer($user)) {
		return $return;
	}

	if ($handler == 'activity'
			|| $handler == 'dashboard') {
		return array(
			'handler' => 'observer',
			'segments' => array(
				0 => 'dashboard'
			)
		);
	}

	return $return;
}

/**
 * Forward observers to their dashboard instead of displaying an index page
 */
function hj_observer_index_page($hook, $handler, $return) {

	$user = elgg_get_logged_in_user_entity();
	if (!hj_observer_is_observer($user)) {
		return $return;
	}

	forward("observer/dashboard");
	return $return;
}