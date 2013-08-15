<?php

/**
 * Check to see if the user is an observer
 *
 * @param ElggUser $user
 * @return boolean
 */
function hj_observer_is_observer($user) {

	if (!elgg_instanceof($user, 'user')) {
		return false;
	}

	global $POLICY_ROLES_CACHE;

	if (isset($POLICY_ROLES_CACHE['observers']) && in_array($user->guid, $POLICY_ROLES_CACHE['observers'])) {
		return true;
	} else {

		$count = elgg_get_entities_from_relationship(array(
			'types' => array('user', 'group', 'site'),
			'relationship' => 'observer',
			'relationship_guid' => $user->guid,
			'inverse_relationship' => false,
			'count' => true
		));


		if ($count) {
			$POLICY_ROLES_CACHE['observers'][] = $user->guid;
			return true;
		}
	}

	return false;
}

/**
 * Check to see if the user is an observed user
 *
 * @param ElggUser $user
 * @return boolean
 */
function hj_observer_is_observed_user($user) {

	if (!elgg_instanceof($user, 'user')) {
		return false;
	}

	if (elgg_is_admin_user($user->guid) || hj_observer_is_observer($user)) {
		return false;
	}

	global $POLICY_ROLES_CACHE;

	if (isset($POLICY_ROLES_CACHE['observed_users']) && in_array($user->guid, $POLICY_ROLES_CACHE['observed_users'])) {
		return true;
	} else {

		$count = elgg_get_entities_from_relationship(array(
			'types' => 'user',
			'relationship' => 'observer',
			'relationship_guid' => $user->guid,
			'inverse_relationship' => true,
			'count' => true
		));

		if ($count) {
			$POLICY_ROLES_CACHE['observed_users'][] = $user->guid;
			return true;
		}

		$offset = 0;
		while ($user_groups = $user->getGroups(null, 1, $offset)) {
			$group = $user_groups[0];
			if (hj_observer_is_observed_group($group)) {
				$POLICY_ROLES_CACHE['observed_users'][] = $user->guid;
				return true;
			}
			$offset++;
		}
	}

	return false;
}

/**
 * Check to see if the group is an observed group
 *
 * @param ElggGroup $user
 * @return boolean
 */
function hj_observer_is_observed_group($group) {

	if (!elgg_instanceof($group, 'group')) {
		return false;
	}

	global $POLICY_ROLES_CACHE;

	if (isset($POLICY_ROLES_CACHE['observed_groups']) && in_array($group->guid, $POLICY_ROLES_CACHE['observed_groups'])) {
		return true;
	} else {

		$count = elgg_get_entities_from_relationship(array(
			'types' => 'group',
			'relationship' => 'observer',
			'relationship_guid' => $group->guid,
			'inverse_relationship' => true,
			'count' => true
		));

		if ($count) {
			$POLICY_ROLES_CACHE['observed_groups'][] = $group->guid;
			return true;
		}
	}

	return false;
}

/**
 * Check to see if the observer has this user in their list
 *
 * @param ElggUser $observer
 * @param ElggUser $user
 * @return boolean
 */
function hj_observer_is_observer_of($observer, $user) {

	if (!elgg_instanceof($observer, 'user') || !elgg_instanceof($user, 'user')) {
		return false;
	}

	if (elgg_is_admin_user($user->guid) || hj_observer_is_observer($user)) {
		return false;
	}

	if ((check_entity_relationship($observer->guid, 'observer', $user->guid))) {
		return true;
	}
	$groups = hj_observer_get_observed_groups($observer);
	if ($groups) {
		foreach ($groups as $group) {
			if ($group->isMember($user))
				return true;
		}
	}
	return false;
}

/**
 * Get observers
 */
function hj_observer_get_observers($user = null) {

	global $POLICY_ROLES_CACHE;

	$observers = elgg_get_entities_from_relationship(array(
		'types' => array('user', 'group'),
		'relationship' => 'observer',
		'relationship_guid' => (elgg_instanceof($user, 'user')) ? $user->guid : null,
		'inverse_relationship' => true,
		'limit' => 9999
	));

	$return = array();
	if ($observers) {
		if (!isset($POLICY_ROLES_CACHE['observers'])) {
			$POLICY_ROLES_CACHE['observers'] = array();
		}
		foreach ($observers as $observer) {
			if (!elgg_instanceof($observer, 'user')) {
				continue;
			}
			if (elgg_is_admin_user($observer->guid)) {
				continue;
			}
			if (!array_key_exists($observer->guid, $return)) {
				$return[$observer->guid] = $observer;
			}
			if (!in_array($observer->guid, $POLICY_ROLES_CACHE['observers'])) {
				$POLICY_ROLES_CACHE['observers'][] = $observer->guid;
			}
		}
	}

	return (sizeof($return)) ? $return : false;
}

/**
 * Get observed users
 */
function hj_observer_get_observed_users($observer = null) {

	global $POLICY_ROLES_CACHE;

	$observed = elgg_get_entities_from_relationship(array(
		'types' => 'user',
		'relationship' => 'observer',
		'relationship_guid' => (elgg_instanceof($observer, 'user')) ? $observer->guid : null,
		'inverse_relationship' => false,
		'limit' => 9999
	));

	$groups = hj_observer_get_observed_groups($observer);
	if ($groups) {
		if (!$observed) {
			$observed = array();
		}
		foreach ($groups as $group) {
			$members = $group->getMembers(9999);
			if ($members) {
				$observed = array_merge($observed, $members);
			}
		}
	}

	$return = array();
	if ($observed) {
		if (!isset($POLICY_ROLES_CACHE['observed_users'])) {
			$POLICY_ROLES_CACHE['observed_users'] = array();
		}
		foreach ($observed as $sup) {
			if (!elgg_instanceof($sup, 'user')) {
				continue;
			}
			if (elgg_is_admin_user($sup->guid) || hj_observer_is_observer($sup)) {
				continue;
			}
			if (!array_key_exists($sup->guid, $return)) {
				$return[$sup->guid] = $sup;
			}
			if (!in_array($sup->guid, $POLICY_ROLES_CACHE['observed_users'])) {
				$POLICY_ROLES_CACHE['observed_users'][] = $sup->guid;
			}
		}
	}

	return (sizeof($return)) ? $return : false;
}

/**
 * Get observed groups
 */
function hj_observer_get_observed_groups($observer = null) {

	global $POLICY_ROLES_CACHE;

	$observed = elgg_get_entities_from_relationship(array(
		'types' => 'group',
		'relationship' => 'observer',
		'relationship_guid' => (elgg_instanceof($observer, 'user')) ? $observer->guid : null,
		'inverse_relationship' => false,
		'limit' => 9999
	));

	$return = array();
	if ($observed) {
		if (!isset($POLICY_ROLES_CACHE['observed_groups'])) {
			$POLICY_ROLES_CACHE['observed_groups'] = array();
		}
		foreach ($observed as $sup) {
			if (!array_key_exists($sup->guid, $return)) {
				$return[$sup->guid] = $sup;
			}
			if (!in_array($sup->guid, $POLICY_ROLES_CACHE['observed_groups'])) {
				$POLICY_ROLES_CACHE['observed_groups'][] = $sup->guid;
			}
		}
	}
	return (sizeof($return)) ? $return : false;
}