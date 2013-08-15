<?php

elgg_register_page_handler('observer', 'hj_observer_page_handler');

function hj_observer_page_handler($page) {

	$user = elgg_get_logged_in_user_entity();

	switch ($page[0]) {

		case 'dashboard' :

			gatekeeper();

			$is_admin = elgg_is_admin_logged_in();
			$is_observer = hj_observer_is_observer($user);

			if (!$is_admin && !$is_observer) {
				return false;
			}

			elgg_set_page_owner_guid($user->guid);

			$title = elgg_echo('hj:observer:activity');
			$content = elgg_view('framework/observer/activity');
			$sidebar = elgg_view('framework/observer/sidebar');

			$layout = elgg_view_layout('content', array(
				'title' => $title,
				'content' => $content,
				'filter' => false,
				'sidebar' => $sidebar
			));
			echo elgg_view_page($title, $layout);
			return true;
			break;

		case 'user' :

			gatekeeper();

			$is_admin = elgg_is_admin_logged_in();
			$is_observer = hj_observer_is_observer($user);

			if (!$is_admin && !$is_observer) {
				return false;
			}

			if (isset($page[1])) {
				$observed_user = get_user_by_username($page[1]);
			}

//			if (!hj_observer_is_observer_of($user, $observed_user)) {
//				forward('observer/dashboard');
//			}

			elgg_set_page_owner_guid($observed_user->guid);

			$filter_context = elgg_extract(2, $page, 'activity');
			$view = "framework/observer/user/$filter_context";
			if (!elgg_view_exists($view)) {
				$view = "framework/observer/user/activity";
			}

			$filter = elgg_view('framework/observer/user/filter', array(
				'filter_context' => $filter_context,
				'entity' => $observed_user
			));

			$content = elgg_view($view, array(
				'entity' => $observed_user
			));
			
			$sidebar = elgg_view('framework/observer/sidebar');

			$layout = elgg_view_layout('content', array(
				'title' => $observed_user->name,
				'content' => $content,
				'filter' => $filter,
				'sidebar' => $sidebar
			));

			echo elgg_view_page($observed_user->name, $layout);
			return true;
			break;


		case 'manage' :

			admin_gatekeeper();

			$user = get_user_by_username($page[1]);
			if (!elgg_instanceof($user, 'user')) {
				return false;
			}

			$title = elgg_echo('hj:observer:manage');
			$content = elgg_view_form('observer/manage', array(), array(
				'entity' => $user
			));

			$layout = elgg_view_layout('content', array(
				'title' => $title,
				'content' => $content,
				'filter' => false
			));

			echo elgg_view_page($title, $layout);
			return true;
			break;

	}

	return false;
}

