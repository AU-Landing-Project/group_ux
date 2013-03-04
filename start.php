<?php

require_once 'lib/hooks.php';
require_once 'lib/events.php';


function group_ux_init() {
  elgg_extend_view('groups/edit', 'groups/edit/default_permissions');
  elgg_extend_view('discussion/replies', 'discussion/replies/join');
  
  // register the group_ux JavaScript
  $js = elgg_get_simplecache_url('js', 'group_ux');
  elgg_register_js('group_ux', $js);
  elgg_register_simplecache_view('js/group_ux');
  
  elgg_register_plugin_hook_handler('route', 'groups', 'group_ux_group_router', 0);
  
  elgg_register_event_handler('create', 'group', 'group_ux_default_permissions_hook', 1000);
  elgg_register_event_handler('update', 'group', 'group_ux_default_permissions_hook', 1000);
  elgg_register_event_handler('pagesetup', 'system', 'group_ux_pagesetup');
  
  $use_feature = elgg_get_plugin_setting('group_feature', 'group_ux');
  if ($use_feature != 'no') {
	elgg_extend_view('js/elgg', 'js/group_ux_feature');
	elgg_extend_view('groups/tool_latest', 'groups/group_ux/featured_content');
  
	elgg_register_plugin_hook_handler('route', 'group', 'group_ux_feature_router');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'group_ux_entity_menu');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'group_ux_feature_owner_block');
	elgg_register_action('group_ux/feature', elgg_get_plugins_path() . 'group_ux/actions/group_feature.php');
	
	elgg_register_widget_type('group_ux_featured', elgg_echo("group_ux:widget:featured:title"), elgg_echo("group_ux:widget:featured:description"), 'groups');
  }
}

elgg_register_event_handler('init', 'system', 'group_ux_init');