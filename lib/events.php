<?php

function group_ux_default_permissions_hook($event, $type, $object) {
  $default_permission = get_input('group_ux_default_permission');
  
  if ($default_permission == 'group_acl') {
	$default_permission = $object->group_acl;
  }
  
  if (is_numeric($default_permission)) {
	$object->group_ux_default_permission = $default_permission;
  }
}