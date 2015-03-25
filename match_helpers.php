<?php

include_once 'season_helpers.php';
include_once 'division_helpers.php';
include_once 'player_helpers.php';
include_once 'map_helpers.php';

function match_row_to_response($db_connection, $row)
{	
	$match_id = $row['match_id'];
	$division_id = $row['division_id'];
	$division_info = get_division_info($db_connection, $division_id);

	echo '{';
	echo '"id": '     . json_encode($match_id, JSON_NUMERIC_CHECK) . ',';
	echo '"href": "'  . BASE_URI . '/seasons/' . $division_info['season_id'] . '/';
	echo 'divisions/' . $division_id . '/matches/' . $match_id. '",';

	echo '"division": ';
	division_id_to_ref_response($division_info);
	echo ',';

	echo '"player1": ';
	player_id_to_ref_response($db_connection, $row['player1_id']);
	echo ',';
	
	echo '"player2": ';
	player_id_to_ref_response($db_connection, $row['player2_id']);
	echo ',';

	echo '"winner": ';
	player_id_to_ref_response($db_connection, $row['winner_id']);
	echo ',';
	
	echo '"map": ';
	map_id_to_ref_response($db_connection, $row['map_id']);
	
	echo '}';
}

function check_match($match)
{
	/*
	 * Check for necessary input and report an error if anything is missing
	 */
	$required = array('division', 'player1', 'player2', 'winner', 'map');
	if (($valid = validate_required($match, $required)) !== TRUE)
	{
		throw new Exception('Failed due to missing field in match: ($valid)');
	}

	$required_id = array('id');
	foreach ($required as $value)
	{
		$cur = $match[$value];
		if (($valid = validate_required($cur, $required_id)) !== TRUE)
		{
			throw new Exception('Failed due to missing field in $cur: ($valid)');
		}
	}
}

function match_exists($db_connection, $division_id, $player1_id, $player2_id)
{
	$is_found = FALSE;
	
	$query_str = "SELECT * FROM matches WHERE division_id=$division_id " .
	 			 "AND (" .
	 			    "(player1_id=$player1_id AND player2_id=$player2_id) OR" .
	 			    "(player1_id=$player2_id AND player2_id=$player1_id)" .
				 ")";
	
	if ($result = $db_connection->query($query_str))
	{
		if ($result->num_rows > 0)
		{
			$is_found = TRUE;
		}
		$result->free();
	}
	else 
	{
		throw new Exception($db_connection->error, $db_connection->errno);
	}
	return $is_found;
}

function create_match($db_connection, $division_id, $player1_id, $player2_id, $map_id)
{
	$insert = "INSERT INTO matches (division_id, player1_id, player2_id, map_id) " .
			  "VALUES ($division_id, $player1_id, $player2_id, $map_id)";

	if (!$result = $db_connection->query($insert))
	{
		throw new Exception($db_connection->error, $db_connection->errno);
	}	
}

function generate_matches_for_player($db_connection, $division_id, $player_id)
{
	$division_info = get_division_info($db_connection, $division_id);
	
	$players = get_division_players($db_connection, $division_id);
	$maps = get_season_maps($db_connection, $division_info['season_id']);
	
	for ($i = 0; $i < count($players); $i++)
	{
		for ($j = $i + 1; $j < count($players); $j++)
		{
			if (!match_exists($db_connection, $division_id, $players[$i], $players[$j]))
			{
				$random_map_index = mt_rand(0, count($maps) - 1);
				create_match($db_connection, $division_id, $players[$i], $players[$j], $maps[$random_map_index]);
			}
		}
	}
}

