<?php

$observer = elgg_get_logged_in_user_entity();
$user = elgg_get_page_owner_entity();

if (!hj_observer_is_observer_of($observer, $user)) {
	return;
}

$in_clause = "$user->guid";

$dbprefix = elgg_get_config('dbprefix');

$options['joins'][] = "JOIN {$dbprefix}entities r_obj ON r_obj.guid = rv.object_guid";
$options['joins'][] = "JOIN {$dbprefix}entities r_subj ON r_subj.guid = rv.subject_guid";
$options['joins'][] = "JOIN {$dbprefix}users_entity r_subj_ue ON r_subj_ue.guid = rv.subject_guid";

$options['wheres'][] = "(r_obj.guid IN ($in_clause)
							OR r_obj.owner_guid IN ($in_clause)
							OR r_obj.container_guid IN ($in_clause)
							OR r_subj.guid IN ($in_clause))";

if (HYPEOBSERVER_IGNORE_RIVER_ACCESS) {
	$ia = elgg_set_ignore_access(true);
	echo elgg_list_river($options);
	elgg_set_ignore_access($ia);
} else {
	$options['wheres'][] = get_access_sql_suffix('r_obj');
	$options['wheres'][] = get_access_sql_suffix('r_subj');
	echo elgg_list_river($options);
}