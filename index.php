<?php
include_once 'common.php';

/*
 * Validate caller is on whitelist
 */
$is_authorized = FALSE;
$client_ip = $_SERVER['REMOTE_ADDR'];

foreach ($WHITE_LIST as $key)
{
	if (strcasecmp($client_ip, $key) == 0)
	{
		$is_authorized = TRUE;
		break;
	}
}
if (!$is_authorized)
{
	http_response_code(401);
	die();
}


/* 
 * Initialize Epiphany's route module
 */
Epi::setPath('base', '../src');
Epi::init('route');
Epi::setSetting('exceptions', TRUE);

/*
 * Include all the resource source files, each source file
 * is responsible for adding the necessary routes.
 */
include_once 'collection_seasons.php';
include_once 'collection_players.php';
include_once 'collection_maps.php';
include_once 'collection_divisions.php';
include_once 'collection_matches.php';
include_once 'collection_rounds.php';
include_once 'collection_standings.php';
include_once 'collection_links.php';
include_once 'resource_season.php';
include_once 'resource_player.php';
include_once 'resource_map.php';
include_once 'resource_division.php';
include_once 'resource_match.php';
include_once 'resource_round.php';
include_once 'resource_link.php';

getRoute()->get('/', 'get_documentation');

try 
{
	getRoute()->run(); 
}
catch (Exception $e)
{
	/*
	 * TODO: Figure out how to differentiate bad route vs. unsupported
	 *       HTTP verb for a valid route so that a more appropriate error
	 *       code is returned.
	 */
	http_response_code(400);
	echo 'Error: ' . $e->getMessage();
}

function get_documentation()
{
	echo 'SC2 Season Manager APIs <br />';
	echo 'by Psistorm.com <br />';
	echo '<br />';
	echo 'URI specification & routes<br />';
	echo '<br />';
	echo 'POST - Add a new resource to a collection<br />';
	echo 'PUT - Update a resource (complete)<br />';
	echo 'DELETE - Delete a resource<br />';
	echo 'GET - Gets a resource or collection<br />';
	echo '<br />';
	echo 'Special notes:<br />';
	echo '<br />';
	echo 'When adding a player to a division, the matches involving the<br />';
	echo 'player are created. To create a match a list of maps are also needed.<br />';
	echo 'Therefore, be sure to add all the season maps before adding<br />';
	echo 'players to a division.<br />';
	echo '<br />';
	echo '[base_uri]/seasons<br />';
	echo '[base_uri]/seasons/[:season_id]<br />';
	echo '[base_uri]/seasons/[:season_id]/divisions<br />';
	echo '[base_uri]/seasons/[:season_id]/divisions/[:division_id]<br />';
	echo '[base_uri]/seasons/[:season_id]/divisions/[:division_id]/rounds<br />';
	echo '[base_uri]/seasons/[:season_id]/divisions/[:division_id]/rounds/[:round_id]<br />';
	echo '[base_uri]/seasons/[:season_id]/divisions/[:division_id]/matches<br />';
	echo '[base_uri]/seasons/[:season_id]/divisions/[:division_id]/matches/[:match_id]<br />';
	echo '[base_uri]/seasons/[:season_id]/divisions/[:division_id]/matches/[:match_id]/links<br />';
	echo '[base_uri]/seasons/[:season_id]/divisions/[:division_id]/matches/[:match_id]/links/[:links_id]<br />';
	echo '[base_uri]/seasons/[:season_id]/divisions/[:division_id]/standings<br />';
	echo '[base_uri]/players/[:player_id]<br />';
	echo '[base_uri]/players/[:player_id]/links<br />';
	echo '[base_uri]/players/[:player_id]/links/[:link_id]<br />';
	echo '[base_uri]/maps/[:map_id]<br />';
	echo '[base_uri]/maps/[:map_id]/links<br />';
	echo '[base_uri]/maps/[:map_id]/links/[:link_id]<br />';
}

