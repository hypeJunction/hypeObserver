<?php

if (elgg_is_admin_logged_in()) {

	elgg_register_menu_item('page', array(
		'name' => 'observers',
		'text' => elgg_echo('hj:observer:admin:observers'),
		'href' => 'admin/observers',
		'priority' => 500,
		'contexts' => array('admin'),
		'section' => 'approve'
	));
}

elgg_register_plugin_hook_handler('register', 'menu:entity', 'hj_observer_entity_menu_setup');
elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'hj_observer_user_hover_menu_setup');

function hj_observer_entity_menu_setup($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	if (!elgg_instanceof($entity)) {
		return $return;
	}

	if (elgg_instanceof($entity, 'user')) {
		if (hj_observer_is_observer($entity)) {
			$return['is_observer'] = ElggMenuItem::factory(array(
						'name' => 'is_observer',
						'text' => elgg_echo("hj:observer:user"),
						'href' => false
			));
		}
	}

	return $return;
}

function hj_observer_user_hover_menu_setup($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	if (elgg_is_admin_logged_in()) {
		if (!hj_observer_is_observer($entity)) {
			$return['observer'] = ElggMenuItem::factory(array(
						'name' => 'observer',
						'text' => elgg_echo('hj:observer:make_observer'),
						'href' => "action/observer/make_observer?guid=$entity->guid",
						'is_action' => true,
						'section' => 'admin'
			));
		} else {
			$return['observer_manage'] = ElggMenuItem::factory(array(
						'name' => 'observer_manage',
						'text' => elgg_echo('hj:observer:manage'),
						'href' => "observer/manage/$entity->username",
						'section' => 'admin'
			));
			$return['observer'] = ElggMenuItem::factory(array(
						'name' => 'observer',
						'text' => elgg_echo('hj:observer:revoke_observer'),
						'href' => "action/observer/revoke_observer?guid=$entity->guid",
						'is_action' => true,
						'section' => 'admin'
			));
		}
	}

	return $return;
}

$user = elgg_get_logged_in_user_entity();
if ($user && (hj_observer_is_observer($user))) {
	elgg_register_menu_item('topbar', array(
		'name' => 'dashboard',
		'href' => 'observer/dashboard',
		'text' => elgg_view_icon('home') . elgg_echo('dashboard'),
		'priority' => 300,
		'section' => 'alt',
	));
}