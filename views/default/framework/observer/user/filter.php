<?php

$filter_context = elgg_extract('filter_context', $vars, 'activity');
$entity = elgg_extract('entity', $vars, null);

if (!$entity) {
	return;
}

$tabs = array(
	'activity' => array(
		'text' => elgg_echo('hj:observer:user:activity'),
		'href' => "observer/user/$entity->username/activity",
		'selected' => ($filter_context == 'activity'),
		'priority' => 100,
	),
	'content' => array(
		'text' => elgg_echo('hj:observer:user:content'),
		'href' => "observer/user/$entity->username/content",
		'selected' => ($filter_context == 'content'),
		'priority' => 200,
	),
	'inbox' => (HYPEOBSERVER_INBOX_ACCESS) ? array(
		'text' => elgg_echo('hj:observer:user:inbox'),
		'href' => "observer/user/$entity->username/inbox",
		'selected' => ($filter_context == 'inbox'),
		'priority' => 300,
			) : NULL,
	'outbox' => (HYPEOBSERVER_OUTBOX_ACCESS) ? array(
		'text' => elgg_echo('hj:observer:user:outbox'),
		'href' => "observer/user/$entity->username/outbox",
		'selected' => ($filter_context == 'outbox'),
		'priority' => 400,
			) : NULL,
	'annotations' => (HYPEOBSERVER_ANNOTATIONS_ACCESS) ? array(
		'text' => elgg_echo('hj:observer:user:annotations'),
		'href' => "observer/user/$entity->username/annotations",
		'selected' => ($filter_context == 'annotations'),
		'priority' => 500,
	) : NULL,
//	'relationships' => array(
//		'text' => elgg_echo('hj:observer:user:relationships'),
//		'href' => "observer/user/$entity->username/relationships",
//		'selected' => ($filter_context == 'relationships'),
//		'priority' => 200,
//	),
);


foreach ($tabs as $name => $tab) {
	if ($tab) {
		$tab['name'] = $name;
		elgg_register_menu_item('filter', $tab);
	}
}

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
