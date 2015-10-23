<?php

namespace AU\GroupUX;

$show_add_form = elgg_extract('show_add_form', $vars, true);
$group = $vars['topic']->getContainerEntity();

if (elgg_is_logged_in() && !$group->isMember() && !$show_add_form) {
  if ($group->isPublicMembership() || $group->canEdit()) {
	  $text = 'groups:join';
  }
  else {
    $text = 'groups:joinrequest';
  }
  
  $url = elgg_get_site_url() . "action/groups/join?group_guid={$group->guid}";
  $url = elgg_add_action_tokens_to_url($url);
  $link = elgg_view('output/url', array(
	  'text' => elgg_echo($text),
	  'href' => $url
  ));
  
  echo elgg_view('output/longtext', array(
	 'value' =>  '<hr>' . elgg_echo('groups_ux:discussions:join', array($link)),
	  'class' => 'elgg-subtext'
  ));
  
}