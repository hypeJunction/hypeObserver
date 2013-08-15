<?php

$path = elgg_get_plugins_path() . 'hypeObserver/actions/';

elgg_register_action('hypeObserver/settings/save', $path . 'settings/save.php', 'admin');

elgg_register_action('observer/make_observer', $path . 'make_observer.php', 'admin');
elgg_register_action('observer/revoke_observer', $path . 'revoke_observer.php', 'admin');
elgg_register_action('observer/manage', $path . 'manage_observer.php', 'admin');
