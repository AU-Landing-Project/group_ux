<?php

namespace AU\GroupUX;

echo elgg_echo('group_ux:settings:group:feature') . '<br>';
echo elgg_view('input/dropdown', array(
	'name' => 'params[group_feature]',
	'value' => $vars['entity']->group_feature ? $vars['entity']->group_feature : 'yes',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	)
));

echo '<br><br>';

