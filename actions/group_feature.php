<?php

namespace AU\GroupUX;

$guid = get_input('guid');
$group_guid = get_input('group');

$entity = get_entity($guid);
$group = get_entity($group_guid);

if (!elgg_instanceof($group, 'group') || !$entity || $entity->container_guid != $group->guid) {
	register_error(elgg_echo('group_ux:feature:error:invalid_params'));
	forward(REFERER);
}

if (!$group->canEdit()) {
	register_error(elgg_echo('group_ux:feature:error:invalid_perms'));
	forward(REFERER);
}

if ($entity->group_ux_featured == 1) {
	$entity->group_ux_featured = 0;
} else {
	$entity->group_ux_featured = 1;
}

forward(REFERER);
