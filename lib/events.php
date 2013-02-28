<?php

/**
 *	adds join/request membership button to group pages
 */
function group_ux_pagesetup() {
  $group = elgg_get_page_owner_entity();
  
  if (elgg_is_logged_in() && elgg_instanceof($group, 'group') && !$group->isMember()) {
	$url = elgg_get_site_url() . "action/groups/join?group_guid={$group->getGUID()}";
	$url = elgg_add_action_tokens_to_url($url);
	if ($group->isPublicMembership() || $group->canEdit()) {
	  $text = 'groups:join';
	}
	else {
	  $text = 'groups:joinrequest';
	}
	
	elgg_unregister_menu_item('title', $text);
	
	elgg_register_menu_item('title', array(
				'name' => $text,
				'href' => $url,
				'text' => elgg_echo($text),
				'link_class' => 'elgg-button elgg-button-action',
			));
	
  }
}


/**
 * adds the group default permission as metadata to the group
 * uses value passed from the group edit form
 * 
 * @param type $event
 * @param type $type
 * @param type $object
 */
function group_ux_default_permissions_hook($event, $type, $object) {
  $default_permission = get_input('group_ux_default_permission');
  
  if ($default_permission == 'group_acl') {
	$default_permission = $object->group_acl;
  }
  
  if (is_numeric($default_permission)) {
	$object->group_ux_default_permission = $default_permission;
  }
}