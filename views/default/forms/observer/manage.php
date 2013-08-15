<?php

$observer = elgg_extract('entity', $vars);

if (!elgg_instanceof($observer, 'user')) {
	return;
}

echo '<div>';
echo '<label>' . elgg_echo('hj:observer:user') . '</label>';
echo elgg_view_entity($observer, array(
	'full_view' => false
));
echo '</div>';

$observed_users = elgg_get_entities_from_relationship(array(
	'types' => 'user',
	'relationship' => 'observer',
	'relationship_guid' => $observer->guid,
	'inverse_relationship' => false,
	'limit' => 9999
		));

$guids = array();

if ($observed_users) {
	foreach ($observed_users as $user) {
		$guids[] = $user->guid;
	}
}

echo '<div>';
echo '<label>' . elgg_echo('hj:observer:observed_users') . '</label>';
echo elgg_view('input/userpicker', array(
	'value' => $guids
));
echo '</div>';


$observed_groups = hj_observer_get_observed_groups($observer);

if ($observed_groups) {
	foreach ($observed_groups as $group) {
		$group_values[] = $group->guid;
	}
}

$groups = elgg_get_entities(array(
	'types' => 'group',
	'limit' => 9999
		));

$group_options = array();

if ($groups) {
	foreach ($groups as $group) {
		$str = "$group->name ({$group->getMembers(0, 0, true)})";
		$group_options[$str] = $group->guid;
	}
}

echo '<div>';
echo '<label>' . elgg_echo('hj:observer:observed_groups') . '</label>';
echo '<div class="elgg-text-help">' . elgg_echo('hj:observer:observed_groups:info') . '</div>';

echo elgg_view('input/checkboxes', array(
	'name' => 'groups',
	'value' => $group_values,
	'options' => $group_options
));
echo '</div>';


echo '<div class="elgg-foot">';
echo elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $observer->guid
));
echo elgg_view('input/submit', array(
	'value' => elgg_echo('save')
));
echo '</div>';