<?php

$observer = elgg_get_logged_in_user_entity();
$user = elgg_get_page_owner_entity();

if (!hj_observer_is_observer_of($observer, $user)) {
	return;
}


$ia = elgg_set_ignore_access(true);

$by = elgg_list_annotations(array(
	'annotation_names' => array('generic_comment', 'messageboard', 'group_topic_post'),
	'annotation_owner_guids' => $user->guid,
	'offset_key' => 'offset-by'
		));

$on = elgg_list_annotations(array(
	'annotation_names' => array('generic_comment', 'messageboard', 'group_topic_post'),
	'guids' => $user->guid,
	'offset_key' => 'offset-on'
		));

elgg_set_ignore_access($ia);

echo '<div class="elgg-col elgg-col-1of2">';
echo elgg_view_module('info', elgg_echo("hj:observer:annotations:by", array($user->name)), $by);
echo '</div>';

echo '<div class="elgg-col elgg-col-1of2">';
echo elgg_view_module('info', elgg_echo("hj:observer:annotations:on", array($user->name)), $on);
echo '</div>';
