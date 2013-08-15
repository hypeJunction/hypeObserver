<?php

if (is_null(elgg_get_plugin_setting('restricted_access', 'hypeObserver'))) {
	elgg_set_plugin_setting('restricted_access', true, 'hypeObserver');
}