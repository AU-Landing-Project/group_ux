<?php

namespace AU\GroupUX;

echo elgg_echo('group_ux:widget:num_results') . ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[num_results]',
	'value' => $vars['entity']->num_results ? $vars['entity']->num_results : 10,
	'options' => array_merge(range(1, 10), array(20, 30))
));

echo '<br><br>';
