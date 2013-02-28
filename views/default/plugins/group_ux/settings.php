<?php

$value = elgg_get_plugin_setting('group_default_permissions', 'group_ux');

echo elgg_echo('group_ux:group:default:permissions') . '<br>';
echo elgg_view('input/dropdown', array(
	'name' => 'params[group_default_permissions]',
	'value' => ($value === NULL) ? 'user_default' : $value,
	'options_values' => array(
		ACCESS_PRIVATE => elgg_echo('PRIVATE'),
		ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'),
		ACCESS_PUBLIC => elgg_echo('PUBLIC'),
		'group_acl' => elgg_echo('groups:access:group'),
		'user_default' => elgg_echo('group_ux:user:default')
	)
));
echo elgg_view('output/longtext', array(
	'value' => elgg_echo('group_ux:group:default:permissions:helptext'),
	'class' => 'elgg-subtext'
));

echo '<br><br>';