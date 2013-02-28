<?php

/**
 * Adds title button to requests page, linking to invite users page
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 */
function group_ux_group_router($hook, $type, $return, $params) {
  if ($return['segments'][0] == 'requests') {
	$group = get_entity($return['segments'][1]);
	
	if (elgg_instanceof($group, 'group') && $group->canEdit()) {
	  elgg_set_page_owner_guid($group->guid);
	  elgg_register_title_button('groups', 'invite');
	}
  }
}