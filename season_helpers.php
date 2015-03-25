<?php

include_once 'player_helpers.php';
include_once 'map_helpers.php';

function season_row_to_response($db_connection, $row)
{
	$season_id = $row['season_id'];
	$winner_id = $row['season_winner'];
	
	echo '{';
	echo '"id": '     . json_encode($season_id, JSON_NUMERIC_CHECK) . ',';
	echo '"href": "'  . BASE_URI . '/seasons/' . $season_id . '",';
	echo '"name": '   . json_encode($row['season_name']) . ',';
	echo '"date": '   . json_encode($row['season_start']) . ',';
	
	echo '"winner": ';
	player_id_to_ref_response($db_connection, $winner_id);
	echo ',';
		
	$season_map_ids = get_season_maps($db_connection, $season_id);
	$is_first_map = TRUE;	
	echo '"maps": [';
	foreach ($season_map_ids as $map_id)
	{
		if (!$is_first_map)
		{
			echo ',';
		}
		$is_first_map = FALSE;
		map_id_to_ref_response($db_connection, $map_id);
	}
	echo '],';
	
	echo '"divisions_href": "' . BASE_URI . '/seasons/' . $season_id; 
	echo '/divisions"';
		
	echo '}';
}

function get_season_name($db_connection, $season_id)
{
	$season_name = NULL;
	if ($result = $db_connection->query("SELECT * FROM seasons WHERE season_id=$season_id"))
	{
		if ($result->num_rows == 1)
		{
			while ($row = $result->fetch_assoc())
			{
				$season_name = $row['season_name'];
			}
		}
		$result->free();
	}
	return $season_name;
}

function get_season_href($season_id)
{
	$href = NULL;
	if (!is_null($season_id))
	{
		$href = BASE_URI . '/seasons/' . $season_id;
	}
	return $href;
}

/*
 * Use when referencing a season
 */
function season_id_to_ref_response($db_connection, $season_id)
{
	echo '{';
	echo '"id": '    . json_encode($season_id, JSON_NUMERIC_CHECK) . ',';
	echo '"name": '  . json_encode(get_season_name($db_connection, $season_id)) . ',';
	echo '"href": '  . json_encode(get_season_href($season_id));
	echo '}';
}

function check_season($season)
{
	/*
	 * Check for necessary input and report an error if anything is missing
	 */
	$required = array('name', 'date', 'winner', 'maps');
	if (($valid = validate_required($season, $required)) !== TRUE)
	{
		throw new Exception('Failed due to missing field in season: ($valid)');
	}
	
	$winner = $season['winner'];
	$required = array('id');
	if (($valid = validate_required($winner, $required)) !== TRUE)
	{
		throw new Exception('Failed due to missing field in winner: ($valid)');
	}
	
	$maps = $season['maps'];
	foreach ($maps as $map)
	{
		if (($valid = validate_required($map, $required)) !== TRUE)
		{
			throw new Exception('Failed due to missing field in map: ($valid)');
		}
	}	
}

function get_season_maps($db_connection, $season_id)
{
	$season_maps = array();
	if ($result = $db_connection->query("SELECT * FROM season_maps WHERE season_id=$season_id"))
	{
		while ($row = $result->fetch_assoc())
		{
			$season_maps[] = $row['map_id'];
		}
		$result->free();
	}
	return $season_maps;
}

function add_season_maps($db_connection, $season_id, $maps)
{
	foreach ($maps as $map)
	{
		$insert = 'INSERT INTO season_maps (season_id, map_id) ' .
				'VALUES (' .
				"'" . $season_id . "', " .
				get_sql_value($map, 'id') . ')';

		if (!$result = $db_connection->query($insert))
		{
			throw new Exception($db_connection->error, $db_connection->errno);
		}
	}
}

function del_season_maps($db_connection, $season_id)
{
	if (!$result = $db_connection->query("DELETE FROM season_maps WHERE season_id=$season_id"))
	{
		throw new Exception($db_connection->error, $db_connection->errno);
	}
}


