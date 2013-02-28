<?php

require_once 'lib/hooks.php';
require_once 'lib/events.php';

function group_ux_init() {
  elgg_extend_view('groups/edit', 'groups/edit/default_permissions');
  
  // register the group_ux JavaScript
  $js = elgg_get_simplecache_url('js', 'group_ux');
  elgg_register_js('group_ux', $js);
  elgg_register_simplecache_view('js/group_ux');
  
  elgg_register_event_handler('create', 'group', 'group_ux_default_permissions_hook', 1000);
  elgg_register_event_handler('update', 'group', 'group_ux_default_permissions_hook', 1000);
  
}

elgg_register_event_handler('init', 'system', 'group_ux_init');