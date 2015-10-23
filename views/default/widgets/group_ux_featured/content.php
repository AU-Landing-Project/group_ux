<?php

namespace AU\GroupUX;

$group = $vars['entity']->getContainerEntity();

if (!elgg_instanceof($group, 'group')) {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "group/$group->guid/featured_content",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
		));


$options = array(
	'container_guid' => elgg_get_page_owner_guid(),
	'metadata_names' => array('group_ux_featured'),
	'metadata_values' => array(1),
	'limit' => $vars['entity']->num_results ? $vars['entity']->num_results : 10,
	'full_view' => false,
	'pagination' => false,
);

$content = elgg_list_entities_from_metadata($options);

if (!$content) {
	$content = '<p>' . elgg_echo('group_ux:featured:none') . '</p>';
	$all_link = '';
}


echo $content;

if ($all_link) {
	echo $all_link;
}
