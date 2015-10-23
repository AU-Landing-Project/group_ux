<?php

namespace AU\GroupUX;

/**
 * 	Adds the 'group feature' link to the entity menu
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 */
function entity_menu($hook, $type, $return, $params) {
	$group = elgg_get_page_owner_entity();
	
	if (!$group instanceof \ElggGroup) {
		return $return;
	}
	
	if (!elgg_is_logged_in()) {
		return $return;
	}
	
	if ($group->canEdit()) {
		$container = $params['entity']->getContainerEntity();

		if ($container->guid == $group->guid) {

			$text = elgg_echo('group_ux:group:feature');
			if ($params['entity']->group_ux_featured) {
				$text = elgg_echo('group_ux:group:unfeature');
			}

			$span = '<span data-guid="' . $params['entity']->guid . '" data-group="' . $group->guid . '">' . $text . '</span>';
			$item = new \ElggMenuItem('group_feature', $span, '#');
			$item->setLinkClass('group-ux-feature');

			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Provide group owner_block link to featured content
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 */
function feature_owner_block($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'group')) {
		$url = 'group/' . $params['entity']->guid . '/featured_content';
		$item = new \ElggMenuItem('group_ux_featured', elgg_echo('group_ux:group:featured:sidelink'), $url);

		$return[] = $item;
	}

	return $return;
}

/**
 * Provide a group page for featured content
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 */
function feature_router($hook, $type, $return, $params) {
	if ($return['segments'][1] == 'featured_content') {
		$group = get_entity($return['segments'][0]);

		if (elgg_instanceof($group, 'group')) {
			elgg_set_page_owner_guid($group->guid);

			$options = array(
				'container_guid' => elgg_get_page_owner_guid(),
				'metadata_names' => array('group_ux_featured'),
				'metadata_values' => array(1),
				'full_view' => false,
			);

			$content = elgg_list_entities_from_metadata($options);

			if (!$content) {
				$content = elgg_echo('group_ux:featured:none');
			}

			$title = elgg_echo('group_ux:group:featured:content');

			$layout = elgg_view_layout('content', array(
				'title' => elgg_view_title($title),
				'content' => $content,
				'filter' => false
			));

			echo elgg_view_page($title, $layout);

			return false;
		}
	}
}

/**
 * Adds title button to requests page, linking to invite users page
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 */
function group_router($hook, $type, $return, $params) {
	if ($return['segments'][0] == 'requests') {
		$group = get_entity($return['segments'][1]);

		if (elgg_instanceof($group, 'group') && $group->canEdit()) {
			elgg_set_page_owner_guid($group->guid);
			elgg_register_title_button('groups', 'invite');
		}
	}
}

/**
 * prevent access to blog form if group setting dictates
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 */
function blog_add_block($hook, $type, $return, $params) {

	if ($return['segments'][0] != 'add') {
		return $return;
	}
	
	$group = get_entity($return['segments'][1]);
	if (!$group instanceof \ElggGroup) {
		return $return;
	}

	if (!$group->canEdit() && $group->group_ux_lock_blog_enable == 'yes') {
		//send the user back with a message
		system_message(elgg_echo('group_ux:lockblog:alert'));
		forward('/blog/group/' . $return['segments'][1] . '/all');
		return true;
	}
	
	return $return;
}

/**
 * block the blog action directly
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return boolean
 */
function blog_action($hook, $type, $return, $params) {
	$container = get_entity(get_input('container_guid'));
	if (!$container instanceof \ElggGroup) {
		return $return;
	}
	
	if ($container->group_ux_lock_blog_enable == 'yes' && !$container->canEdit()) {
		register_error(elgg_echo('group_ux:lockblog:alert'));
		return false;
	}
	
	return $return;
}