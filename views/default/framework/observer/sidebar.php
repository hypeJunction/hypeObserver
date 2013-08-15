<?php

$observer = elgg_get_logged_in_user_entity();
$user = elgg_get_page_owner_entity();

$observed_users = hj_observer_get_observed_users($observer);

if ($observed_users) {
	foreach ($observed_users as $u) {
		elgg_register_menu_item('page', array(
			'name' => $u->username,
			'text' => $u->name,
			'href' => "observer/user/$u->username",
			'section' => 'users',
			'selected' => ($user->guid == $u->guid)
		));
	}
}

