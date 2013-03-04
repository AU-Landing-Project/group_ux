<?php

$options_values = array();
for ($i=1; $i<11; $i++) {
  $options_values[$i] = $i;
}

$options_values[20] = 20;
$options_values[30] = 30;

echo elgg_echo('group_ux:widget:num_results') . ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[num_results]',
	'value' => $vars['entity']->num_results ? $vars['entity']->num_results : 10,
	'options_values' => $options_values
));

echo '<br><br>';