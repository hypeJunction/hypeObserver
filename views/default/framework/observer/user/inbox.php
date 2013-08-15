<?php

$observer = elgg_get_logged_in_user_entity();
$user = elgg_get_page_owner_entity();

if (!hj_observer_is_observer_of($observer, $user)) {
	return;
}

if (!HYPEOBSERVER_INBOX_ACCESS) {
	return;
}

$ia = elgg_set_ignore_access(true);
echo elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'messages',
	'metadata_name' => 'toId',
	'metadata_value' => elgg_get_page_owner_guid(),
	'owner_guid' => elgg_get_page_owner_guid(),
	'full_view' => true,
));
elgg_set_ignore_access($ia);
