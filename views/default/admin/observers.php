<?php

$observers = hj_observer_get_observers();

if ($observers) {
	echo '<table class="elgg-table-alt">';
	echo '<tbody>';

	foreach ($observers as $observer) {
		echo '<tr>';
		echo '<td>' . elgg_view_entity($observer, array(
			'full_view' => false
		)) . '</td>';
		echo '<td>' . elgg_view_entity_list(hj_observer_get_observed_users($observer), array(
			'full_view' => false
		)) . '</td>';
		echo '</tr>';
	}

	echo '</tbody>';
	echo '</table>';
} else {
	echo elgg_autop(elgg_echo('hj:observer:noobservers'));
}
