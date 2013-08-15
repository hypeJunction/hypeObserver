<?php

$observer = elgg_get_logged_in_user_entity();
$user = elgg_get_page_owner_entity();

if (!hj_observer_is_observer_of($observer, $user)) {
	return;
}

$in_clause = "$user->guid";

$object_subtypes = elgg_get_config('observer_object_subtypes');

foreach ($object_subtypes as $id => $option) {

	if (!is_numeric($id))
		continue;
	if ($option == 'hide')
		continue;

	$subtype = get_subtype_from_id($id);
	$options = array(
		'types' => 'object',
		'subtypes' => $subtype,
		'full_view' => false,
		'pagination' => true,
		'offset_key' => "offset-$subtype",
		'wheres' => array("(e.guid IN ($in_clause)
							OR e.owner_guid IN ($in_clause)
							OR e.container_guid IN ($in_clause))")
	);

	if ($option == 'unrestricted') {
		$ia = elgg_set_ignore_access(true);
		$list = elgg_list_entities($options);
		elgg_set_ignore_access($ia);
	} else {
		$list = elgg_list_entities($options);
	}

	echo '<div class="elgg-col elgg-col-1of2">';
	echo elgg_view_module('info', elgg_echo("item:object:$subtype"), $list);
	echo '</div>';
	
}