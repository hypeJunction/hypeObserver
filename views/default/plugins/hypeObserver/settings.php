<?php

$entity = elgg_extract('entity', $vars);

echo '<div>';
echo '<label>' . elgg_echo('hj:observer:restricted_access') . '</label>';
echo '<span class="elgg-text-help">' . elgg_echo('hj:observer:restricted_access:help') . '</span>';
echo elgg_view('input/dropdown', array(
	'name' => 'params[restricted_access]',
	'value' => $entity->restricted_access,
	'options_values' => array(
		true => elgg_echo('hj:observer:enable'),
		false => elgg_echo('hj:observer:disable')
	)
));
echo '</div>';

echo '<div>';
echo '<label>' . elgg_echo('hj:observer:ignore_river_access') . '</label>';
echo '<span class="elgg-text-help">' . elgg_echo('hj:observer:ignore_river_access:help') . '</span>';
echo elgg_view('input/dropdown', array(
	'name' => 'params[ignore_river_access]',
	'value' => $entity->ignore_river_access,
	'options_values' => array(
		true => elgg_echo('hj:observer:ignore'),
		false => elgg_echo('hj:observer:respect')
	)
));
echo '</div>';


echo '<div>';
echo '<label>' . elgg_echo('hj:observer:object_subtypes') . '</label>';
echo '<span class="elgg-text-help">' . elgg_echo('hj:observer:object_subtypes:help') . '</span>';
$registered_entities = elgg_get_config('registered_entities');
foreach ($registered_entities as $type => $subtypes) {
	switch ($type) {
		case 'object' :
			$object_subtypes = elgg_get_config('observer_object_subtypes');
			if (count($subtypes)) {
				foreach ($subtypes as $subtype) {
					$label = elgg_echo("item:$type:$subtype");
					$id = get_subtype_id($type, $subtype);
					if ($id) {
						echo '<div>';
						echo '<label>' . elgg_echo("item:$type:$subtype") . '</label>';
						echo elgg_view('input/dropdown', array(
							'name' => "params[object_subtypes][$id]",
							'value' => $object_subtypes[$id],
							'options_values' => array(
								'hide' => elgg_echo('hj:observer:object_subtypes:hide'),
								'default' => elgg_echo('hj:observer:object_subtypes:default'),
								'unrestricted' => elgg_echo('hj:observer:object_subtypes:unrestricted')
							)
						));
						echo '</div>';
					}
				}
			}
			break;
	}
}
echo '</div>';

echo '<div>';
echo '<label>' . elgg_echo('hj:observer:inbox_access') . '</label>';
echo '<span class="elgg-text-help">' . elgg_echo('hj:observer:inbox_access:help') . '</span>';
echo elgg_view('input/dropdown', array(
	'name' => 'params[inbox_access]',
	'value' => $entity->inbox_access,
	'options_values' => array(
		true => elgg_echo('hj:observer:allow'),
		false => elgg_echo('hj:observer:deny')
	)
));
echo '</div>';

echo '<div>';
echo '<label>' . elgg_echo('hj:observer:outbox_access') . '</label>';
echo '<span class="elgg-text-help">' . elgg_echo('hj:observer:outbox_access:help') . '</span>';
echo elgg_view('input/dropdown', array(
	'name' => 'params[outbox_access]',
	'value' => $entity->outbox_access,
	'options_values' => array(
		true => elgg_echo('hj:observer:allow'),
		false => elgg_echo('hj:observer:deny')
	)
));
echo '</div>';


echo '<div>';
echo '<label>' . elgg_echo('hj:observer:annotations_access') . '</label>';
echo '<span class="elgg-text-help">' . elgg_echo('hj:observer:annotations_access:help') . '</span>';
echo elgg_view('input/dropdown', array(
	'name' => 'params[annotations_access]',
	'value' => $entity->annotations_access,
	'options_values' => array(
		true => elgg_echo('hj:observer:allow'),
		false => elgg_echo('hj:observer:deny')
	)
));
echo '</div>';