<?php

namespace AU\GroupUX;

/**
 * Group set module
 */
$group = elgg_get_page_owner_entity();

$all_link = elgg_view('output/url', array(
	'href' => "group/$group->guid/featured_content",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
		));

elgg_push_context('widgets');
$options = array(
	'container_guid' => elgg_get_page_owner_guid(),
	'metadata_names' => array('group_ux_featured'),
	'metadata_values' => array(1),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);
$content = elgg_list_entities_from_metadata($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('group_ux:featured:none') . '</p>';
}


echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('group_ux:group:featured:content'),
	'content' => $content,
	'all_link' => $all_link,
));
