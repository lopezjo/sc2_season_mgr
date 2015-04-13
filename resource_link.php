<?php

include_once 'common.php';

/*
 * Add routes
 */

getRoute()->get('/seasons/(\d+)/divisions/(\d+)/matches/(\d+)/links/(\d+)', 'get_link_by_match');
getRoute()->get('/players/(\d+)/links/(\d+)', 'get_link_by_player');
getRoute()->get('/maps/(\d+)/links/(\d+)', 'get_link_by_map');

getRoute()->put('/seasons/(\d+)/divisions/(\d+)/matches/(\d+)/links/(\d+)', 'update_link_by_match');
getRoute()->put('/players/(\d+)/links/(\d+)', 'update_link_by_player');
getRoute()->put('/maps/(\d+)/links/(\d+)', 'update_link_by_map');

getRoute()->delete('/seasons/(\d+)/divisions/(\d+)/matches/(\d+)/links/(\d+)', 'del_link_by_match');
getRoute()->delete('/players/(\d+)/links/(\d+)', 'del_link_by_player');
getRoute()->delete('/maps/(\d+)/links/(\d+)', 'del_link_by_map');

/*
 * Implementation of resource
 */
function get_link_by_match($season_id, $division_id, $match_id, $link_id)
{
	$href_prefix = '/seasons/'   . $season_id .
				   '/divisions/' . $division_id .
				   '/matches/'   . $match_id;
	get_link($link_id, "match_id", $match_id, $href_prefix);	
}

function get_link_by_player($player_id, $link_id)
{
	$href_prefix = '/players/' . $player_id;
	get_link($link_id, "player_id", $player_id, $href_prefix);
}

function get_link_by_map($map_id, $link_id)
{
	$href_prefix = '/maps/' . $map_id;
	get_link($link_id, "map_id", $map_id, $href_prefix);
}

function update_link_by_match($season_id, $division_id, $match_id, $link_id)
{
	update_link($link_id, "match_id", $match_id);
}

function update_link_by_player($player_id, $link_id)
{
	update_link($link_id, "player_id", $player_id);
}

function update_link_by_map($map_id, $link_id)
{
	update_link($link_id, "map_id", $map_id);
}

function del_link_by_match($season_id, $division_id, $match_id, $link_id)
{
	delete_link($link_id, "match_id", $match_id);
}

function del_link_by_player($player_id, $link_id)
{
	delete_link($link_id, "player_id", $player_id);
}

function del_link_by_map($map_id, $link_id)
{
	delete_link($link_id, "map_id", $map_id);
}
