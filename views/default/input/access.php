<?php
/**
 * Elgg access level input
 * Displays a dropdown input field
 *
 * @uses $vars['value']          The current value, if any
 * @uses $vars['options_values'] Array of value => label pairs (overrides default)
 * @uses $vars['name']           The name of the input field
 * @uses $vars['entity']         Optional. The entity for this access control (uses access_id)
 * @uses $vars['class']          Additional CSS class
 */

if (isset($vars['class'])) {
	$vars['class'] = "elgg-input-access {$vars['class']}";
} else {
	$vars['class'] = "elgg-input-access";
}

$value = get_default_access();
$group = elgg_get_page_owner_entity();
if (elgg_instanceof($group, 'group') && $vars['name'] != 'membership') {
  $indicator = $group->group_ux_default_permission;
  if ($indicator === NULL) {
	$indicator = elgg_get_plugin_setting('group_ux_default_permissions');
  }
  
  if ($indicator !== NULL) {
	if (is_numeric($indicator)) {
	  $value = $indicator;
	}
	elseif ($indicator == 'group_acl') {
	  $value = $group->group_acl;
	}
	else {
	  // nothing to change, already default access
	}
  }

  
  // because some plugins send default in $vars...
  // we need to honor them if it's an edit page
  // the elgg-pattern us url/handler/edit/guid
  $base_path = parse_url(elgg_get_site_url(), PHP_URL_PATH);
  $current_path = parse_url(current_page_url(), PHP_URL_PATH);
  if ($base_path != '/') {
    $current_path = str_replace($base_path, '', $current_path);
  } else {
    $current_path = substr($current_path, 1);
  }
  $parts = explode('/', $current_path);

  if (!$vars['entity'] && !in_array('edit', $parts) && elgg_get_context() != 'widgets') {
    $vars['value'] = $value;
  }
}

$defaults = array(
	'disabled' => false,
	'value' => $value,
	'options_values' => get_write_access_array(),
);

if (isset($vars['entity'])) {
	$defaults['value'] = $vars['entity']->access_id;
	unset($vars['entity']);
}

$vars = array_merge($defaults, $vars);

if ($vars['value'] == ACCESS_DEFAULT) {
	$vars['value'] = get_default_access();
}

if (is_array($vars['options_values']) && sizeof($vars['options_values']) > 0) {
	echo elgg_view('input/dropdown', $vars);
}
