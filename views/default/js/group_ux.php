elgg.provide('elgg.group_ux');

elgg.group_ux.init = function() {
  
  elgg.group_ux.position_default();

}

elgg.group_ux.position_default = function() {
  var target = $('select.elgg-input-access[name="vis"]').parents('div').eq(0);
  
  $('#group-ux-default-permission').insertAfter(target);
  $('#group-ux-default-permission').show(); // necessary for group_tools compatibility
}

elgg.register_hook_handler('init', 'system', elgg.group_ux.init);