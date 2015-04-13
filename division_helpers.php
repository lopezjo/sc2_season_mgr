<?php

include_once 'season_helpers.php';
include_once 'player_helpers.php';
include_once 'match_helpers.php';

function division_row_to_response($db_connection, $row)
{
	$division_id = $row['division_id'];
	$season_id = $row['season_id'];
		
	echo '{';
	echo '"id": '     . json_encode($division_id, JSON_NUMERIC_CHECK) . ',';
	echo '"href": "'  . BASE_URI . '/seasons/' . $season_id . '/';
	echo 'divisions/' . $division_id . '",';
	echo '"name": '   . json_encode($row['division_name']) . ',';

	echo '"season": ';
	season_id_to_ref_response($db_connection, $season_id);
	echo ',';

	$division_player_ids = get_division_players($db_connection, $division_id);
	$is_first_player = TRUE;
	echo '"players": [';
	foreach ($division_player_ids as $player_id)
	{
		if (!$is_first_player)
		{
			echo ',';
		}
		$is_first_player = FALSE;
		player_id_to_ref_response($db_connection, $player_id);
	}
	echo '],';

	echo '"matches_href": "' . BASE_URI . '/seasons/' . $season_id;
	echo '/divisions/' . $division_id . '/matches",';

	echo '"rounds_href": "' . BASE_URI . '/seasons/' . $season_id;
	echo '/divisions/' . $division_id . '/rounds",';
	
	echo '"standings_href": "' . BASE_URI . '/seasons/' . $season_id;
	echo '/divisions/' . $division_id . '/standings"';
	
	echo '}';
}

/*
 * Use when referencing a division
 */
function division_id_to_ref_response($division_info)
{
	echo '{';
	echo '"id": '    . json_encode($division_info['division_id'], JSON_NUMERIC_CHECK) . ',';
	echo '"name": '  . json_encode($division_info['division_name']) . ',';
	echo '"href": '  . json_encode(get_division_href($division_info));
	echo '}';
}

function get_division_info($db_connection, $division_id)
{
	$info = NULL;
	if ($result = $db_connection->query("SELECT * FROM divisions WHERE division_id=$division_id"))
	{
		if ($result->num_rows == 1)
		{
			$info = $result->fetch_assoc();
		}
		$result->free();
	}
	return $info;
}

function get_division_href($division_info)
{
	$href = NULL;
	if (!is_null($division_info))
	{
		$href = BASE_URI . '/seasons/' . $division_info['season_id'] .
		        '/divisions/' . $division_info['division_id'];
	}
	return $href;
}

function get_division_players($db_connection, $division_id)
{
	$division_player_ids = array();
	if ($result = $db_connection->query("SELECT * FROM division_players WHERE division_id=$division_id"))
	{
		while ($row = $result->fetch_assoc())
		{
			$division_player_ids[] = $row['player_id'];
		}
		$result->free();
	}
	return $division_player_ids;
}

function check_division($division)
{
	/*
	 * Check for necessary input and report an error if anything is missing
	 */
	$required = array('name', 'season', 'players');
	if (($valid = validate_required($division, $required)) !== TRUE)
	{
		throw new Exception('Failed due to missing field in division: ($valid)');
	}

	$season = $division['season'];
	$required = array('id');
	if (($valid = validate_required($season, $required)) !== TRUE)
	{
		throw new Exception('Failed due to missing field in season: ($valid)');
	}

	$players = $division['players'];
	foreach ($players as $player)
	{
		if (($valid = validate_required($player, $required)) !== TRUE)
		{
			throw new Exception('Failed due to missing field in player: ($valid)');
		}
	}
}

function update_division_players($db_connection, $division_id, $players)
{
	$prev_players = get_division_players($db_connection, $division_id);
	$curr_players = array();
	
	/*
	 * Add new players to division
	 */
	foreach ($players as $player)
	{
		$curr_players[] = $player['id'];
		
		/*
		 * If the player already exists, then do nothing.
		 */
		if (in_array($player['id'], $prev_players))
		{
			continue;
		}
		
		$insert = 'INSERT INTO division_players (division_id, player_id) ' .
				  'VALUES (' .
				  "'" . $division_id . "', " .
				  get_sql_value($player, 'id') . ')';

		if (!$result = $db_connection->query($insert))
		{
			throw new Exception($db_connection->error, $db_connection->errno);
		}
		
		/*
		 * Generate matches for player
		 */
		generate_matches_for_player($db_connection, $division_id, $player['id']);
	}
	
	/*
	 * Remove players from division
	 */
	foreach ($prev_players as $player_id)
	{
		if (!in_array($player_id, $curr_players))
		{
			del_division_player($db_connection, $division_id, $player_id);
		}
	}
}

function del_division_player($db_connection, $division_id, $player_id)
{
	if (!$result = $db_connection->query("DELETE FROM division_players WHERE division_id=$division_id AND player_id=$player_id"))
	{
		throw new Exception($db_connection->error, $db_connection->errno);
	}
	
	if (!$result = $db_connection->query("DELETE FROM matches WHERE division_id=$division_id AND (player1_id=$player_id OR player2_id=$player_id)"))
	{
		throw new Exception($db_connection->error, $db_connection->errno);
	}
}
