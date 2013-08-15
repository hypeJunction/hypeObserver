<?php

$english = array(
	'hj:observer:restricted_access' => 'Enable restricted mode',
	'hj:observer:restricted_access:help' => 'In restricted mode, observers will only have access to their dashboard, pages owned by observed users and groups. In restricted mode, observers will not be able to perform any actions.',
	'hj:observer:enable' => 'Enable restricted mode',
	'hj:observer:disable' => 'Disable restricted mode',

	'hj:observer:ignore_river_access' => 'Access to activity',
	'hj:observer:ignore_river_access:help' => 'Ignore access levels when rendering an activity stream for observed users',
	'hj:observer:ignore' => 'Ignore access levels',
	'hj:observer:respect' => 'Respect privacy settings',

	'hj:observer:object_subtypes' => 'Access to content items',
	'hj:observer:object_subtypes:help' => 'Here you can specify which content items should be displayed on the observers dashboard, and whether visibility settings should be ignored',
	'hj:observer:object_subtypes:hide' => 'Do not show',
	'hj:observer:object_subtypes:default' => 'Show and respect access settings',
	'hj:observer:object_subtypes:unrestricted' => 'Ignore access levels and show all',

	'hj:observer:inbox_access' => 'Access to inbox',
	'hj:observer:inbox_access:help' => 'Give unrestricted access to observed users inbox',
	'hj:observer:outbox_access' => 'Access to outbox',
	'hj:observer:outbox_access:help' => 'Give unrestricted access to observed users outbox',
	'hj:observer:annotations_access' => 'Access to annotations',
	'hj:observer:annotations_access:help' => 'Give unrestricted access to observed users comments, messageboard posts, group topic replies',
	
	'hj:observer:allow' => 'Allow',
	'hj:observer:deny' => 'Deny',
	
	'hj:observer:restricted_area' => 'Restricted area',
	'hj:observer:restricted_area:description' => 'Policy of this site does not allow you to access this page. Please contact the site administrator if you feel that you should be able to access this content',

	'hj:observer:admin:observers' => 'Observers',
	'admin:observers' => 'Observers',
	'hj:observer:noobservers' => 'There are no observer accounts on this site',

	'hj:observer:user' => 'Observer',
	'hj:observer:manage' => 'Observed users',
	'hj:observer:notfound' => 'Observer was not found',
	'hj:observer:observed_users' => 'Observed users',
	'hj:observer:observed_users:add' => '%s users added to the observed users list',
	'hj:observer:observed_users:delete' => '%s users were removed from the observed users list',
	'hj:observer:observed_groups' => 'Observed groups',
	'hj:observer:observed_groups:members' => 'Members of the observed groups',
	'hj:observer:observed_groups:info' => 'By adding a group to the observed groups list, you are actually adding all members of that group to the observer\'s list of observed users',
	'hj:observer:observed_groups:add' => '%s groups added to the observed groups list',
	'hj:observer:observed_groups:delete' => '%s groups were removed from the observed groups list',
	'hj:observer:observed_users_groups:error' => '%s relationships could not be established. Possibly due to conflicts in the hierarchy of user roles',

	'hj:observer:make_observer' => 'Make observer',
	'hj:observer:revoke_observer' => 'Remove observer restrictions',
	'hj:observer:make_observer:success' => 'Observer restrictions were applied successfully',
	'hj:observer:make_observer:error' => 'Observer restrictions could not be applied',
	'hj:observer:revoke_observer:success' => 'Observer restrictions were lifted successfully',
	'hj:observer:revoke_observer:error' => 'Observer restrictions could not be lifted',

	'hj:observer:activity' => 'Latest Activity',

	'hj:observer:user:activity' => 'Activity',
	'hj:observer:user:content' => 'Content Items',
	'hj:observer:user:inbox' => 'Inbox',
	'hj:observer:user:outbox' => 'Outbox',
	'hj:observer:user:annotations' => 'Comments/Annotations',
	'hj:observer:user:relationships' => 'Relationships',

	'hj:observer:annotations:by' => 'By %s',
	'hj:observer:annotations:on' => 'To %s',

);

add_translation("en", $english);
?>