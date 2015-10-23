<?php

namespace AU\GroupUX;

/**
 * 	adds join/request membership button to group pages
 */
function pagesetup() {
	$group = elgg_get_page_owner_entity();

	if (!$group instanceof \ElggGroup) {
		return true;
	}

	// remove the blog add button if group admin has locked the blog
	if (elgg_is_active_plugin("blog")) {
		if ($group instanceof \ElggGroup && $group->group_ux_lock_blog_enable == 'yes') {
			//unregister the add button for non admins
			if (!$group->canEdit() && elgg_get_context() == 'blog') {
				elgg_unregister_menu_item('title', 'add');
			}
		}
	}

	if (elgg_is_logged_in() && !$group->isMember()) {
		$url = elgg_get_site_url() . "action/groups/join?group_guid={$group->guid}";
		$url = elgg_add_action_tokens_to_url($url);
		if ($group->isPublicMembership() || $group->canEdit()) {
			$text = 'groups:join';
		} else {
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
