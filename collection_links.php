<?php

include_once 'common.php';
include_once 'link_helpers.php';

/*
 * Add routes
 */
getRoute()->get('/seasons/(\d+)/divisions/(\d+)/matches/(\d+)/links', 'get_links_by_match');
getRoute()->get('/players/(\d+)/links', 'get_links_by_player');
getRoute()->get('/maps/(\d+)/links', 'get_links_by_map');

getRoute()->post('/seasons/(\d+)/divisions/(\d+)/matches/(\d+)/links', 'add_link_to_match');
getRoute()->post('/players/(\d+)/links', 'add_link_to_player');
getRoute()->post('/maps/(\d+)/links', 'add_link_to_map');


/*
 * Implementation of resource
 */
function get_links_by_player($player_id)
{
	$href_prefix = '/players/' . $player_id;
	get_links("player_id", $player_id, $href_prefix);
}

function get_links_by_map($map_id)
{
	$href_prefix = '/maps/' . $map_id;
	get_links("map_id", $map_id, $href_prefix);
}

function get_links_by_match($season_id, $division_id, $match_id)
{
	$href_prefix = '/seasons/'   . $season_id .
				   '/divisions/' . $division_id .
				   '/matches/'   . $match_id;
	get_links("match_id", $match_id, $href_prefix);
}

function add_link_to_match($season_id, $division_id, $match_id)
{
	$href_prefix = '/seasons/'   . $season_id .
				   '/divisions/' . $division_id .
				   '/matches/'   . $match_id;
	add_link("match_id", $match_id, $href_prefix);
}

function add_link_to_player($player_id)
{
	$href_prefix = '/players/' . $player_id;
	add_link("player_id", $player_id, $href_prefix);
}

function add_link_to_map($map_id)
{
	$href_prefix = '/maps/' . $map_id;
	add_link("map_id", $map_id, $href_prefix);
}
