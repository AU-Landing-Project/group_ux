<?php

elgg_load_js('group_ux');

$value = $vars['entity']->group_ux_default_permission;
if ($value === NULL) {
  $value = elgg_get_plugin_setting('group_default_permissions', 'group_ux');
}
if ($value === NULL) {
  $value = 'user_default';
}

$options_values = array(
	ACCESS_PRIVATE => elgg_echo('PRIVATE'),
	ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'),
	ACCESS_PUBLIC => elgg_echo('PUBLIC'),
	'group_acl' => elgg_echo('groups:access:group'),
	'user_default' => elgg_echo('group_ux:user:default')
);

$label = elgg_echo('group_ux:default:permissions');
$input = elgg_view('input/dropdown', array(
	'name' => 'group_ux_default_permission',
	'value' => $value,
	'options_values' => $options_values
));

$helptext = elgg_view('output/longtext', array(
	'value' => elgg_echo('group_ux:default:permissions:helptext'),
	'class' => 'elgg-subtext'
));
?>

<div id="group-ux-default-permission">
	<label><?php echo $label; ?></label><br />
	<?php echo $input; ?><br />
	<?php echo $helptext; ?>
</div>