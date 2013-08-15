<?php

$guid = get_input('guid');
$user = get_entity($guid);

if (elgg_instanceof($user, 'user')) {
	$site = elgg_get_site_entity();
	if (check_entity_relationship($user->guid, 'observer', $site->guid)) {
		remove_entity_relationship($user->guid, 'observer', $site->guid);
	} else {
		$error = true;
	}
} else {
	$error = true;
}

if (!$error) {
	system_message(elgg_echo('hj:observer:revoke_observer:success'));
} else {
	register_error(elgg_echo('hj:observer:revoke_observer:error'));
}

forward(REFERER);