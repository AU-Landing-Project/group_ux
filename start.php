<?php

namespace AU\GroupUX;

const PLUGIN_ID = 'group_ux';

require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/events.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

function init() {
	elgg_extend_view('discussion/replies', 'discussion/replies/join');

	elgg_register_plugin_hook_handler('route', 'groups', __NAMESPACE__ . '\\group_router', 0);
	elgg_register_plugin_hook_handler('route', 'blog', __NAMESPACE__ . '\\blog_add_block', 0);
	elgg_register_plugin_hook_handler('action', 'blog/save', __NAMESPACE__ . '\\blog_action');

	elgg_register_event_handler('pagesetup', 'system', __NAMESPACE__ . '\\pagesetup');

	$use_feature = elgg_get_plugin_setting('group_feature', PLUGIN_ID);
	if ($use_feature != 'no') {
		
		elgg_require_js('group_ux/feature');
		
		elgg_extend_view('groups/tool_latest', 'groups/group_ux/featured_content');

		elgg_register_plugin_hook_handler('route', 'group', __NAMESPACE__ . '\\feature_router');
		elgg_register_plugin_hook_handler('register', 'menu:entity', __NAMESPACE__ . '\\entity_menu');
		elgg_register_plugin_hook_handler('register', 'menu:owner_block', __NAMESPACE__ . '\\feature_owner_block');
		elgg_register_action('group_ux/feature', __DIR__ . '/actions/group_feature.php');

		elgg_register_widget_type('group_ux_featured', elgg_echo("group_ux:widget:featured:title"), elgg_echo("group_ux:widget:featured:description"), array('groups'));
	}

	//add option to turn off blog for non group admins
	add_group_tool_option('group_ux_lock_blog', elgg_echo('group_ux:lockblog'), false);
}
