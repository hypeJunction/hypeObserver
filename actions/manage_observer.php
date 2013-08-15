<?php

$guid = get_input('guid');
$members = get_input('members', array());
$groups = get_input('groups', array());

$observer = get_entity($guid);

if (!elgg_instanceof($observer)) {
	register_error('hj:observer:notfound');
	forward(REFERER);
}

$current_observed_users = elgg_get_entities_from_relationship(array(
	'types' => 'user',
	'relationship' => 'observer',
	'relationship_guid' => $observer->guid,
	'inverse_relationship' => false,
	'limit' => 9999
		));
$current_guids = array();
if ($current_observed_users) {
	foreach ($current_observed_users as $user) {
		$current_guids[] = $user->guid;
	}
}

$deleted_count = $added_count = $error_count = 0;

$to_delete = array_diff($current_guids, $members);
$to_add = array_diff($members, $current_guids);

if ($to_delete) {
	foreach ($to_delete as $d) {
		if (check_entity_relationship($observer->guid, 'observer', $d)) {
			if (remove_entity_relationship($observer->guid, 'observer', $d)) {
				$deleted_count++;
			} else {
				$error_count++;
			}
		}
	}
}

if ($to_add) {
	foreach ($to_add as $a) {
		if (!check_entity_relationship($observer->guid, 'observer', $a)) {
			if (add_entity_relationship($observer->guid, 'observer', $a)) {
				$added_count++;
			} else {
				$error_count++;
			}
		}
	}
}

if ($added_count)
	system_message(elgg_echo('hj:observer:observed_users:add', array($added_count)));

if ($deleted_count)
	system_message(elgg_echo('hj:observer:observed_users:delete', array($deleted_count)));



$current_observed_groups = elgg_get_entities_from_relationship(array(
	'types' => 'group',
	'relationship' => 'observer',
	'relationship_guid' => $observer->guid,
	'inverse_relationship' => false,
	'limit' => 9999
		));
$current_group_guids = array();
if ($current_observed_groups) {
	foreach ($current_observed_groups as $user) {
		$current_group_guids[] = $user->guid;
	}
}

$deleted_count = $added_count = 0;

$to_delete = array_diff($current_group_guids, $groups);
$to_add = array_diff($groups, $current_group_guids);

if ($to_delete) {
	foreach ($to_delete as $d) {
		if (check_entity_relationship($observer->guid, 'observer', $d)) {
			if (remove_entity_relationship($observer->guid, 'observer', $d)) {
				$deleted_count++;
			} else {
				$error_count++;
			}
		}
	}
}

if ($to_add) {
	foreach ($to_add as $a) {
		if (!check_entity_relationship($observer->guid, 'observer', $a)) {
			if (add_entity_relationship($observer->guid, 'observer', $a)) {
				$added_count++;
			} else {
				$error_count++;
			}
		}
	}
}

if ($added_count)
	system_message(elgg_echo('hj:observer:observed_groups:add', array($added_count)));

if ($deleted_count)
	system_message(elgg_echo('hj:observer:observed_groups:delete', array($deleted_count)));


if ($error_count)
	system_message(elgg_echo('hj:observer:observed_users_groups:error', array($error_count)));

forward(REFERER);