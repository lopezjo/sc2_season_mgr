<?php

function round_to_response($db_connection, $season_id, $division_id, $round_id, & $players)
{
	echo '{';
	echo '"id": ' . json_encode($round_id, JSON_NUMERIC_CHECK) . ',';
	echo '"href": "'  . BASE_URI . '/seasons/' . $season_id . '/';
	echo 'divisions/' . $division_id . '/rounds/' . $round_id . '",';
	
	echo '"matches": [';
	
	$player_count = count($players);
	$is_first = TRUE;
	for ($j = 0; $j < $player_count / 2; ++$j)
	{
		$match_row = find_match($db_connection, $division_id,
				$players[$j], $players[$player_count - 1 - $j]);
		if (!is_null($match_row))
		{
			if (!$is_first)
			{
				echo ',';
			}
			$is_first = FALSE;
	
			match_row_to_response($db_connection, $match_row);
		}
	}
	echo ']';
	echo '}';	
}

function shift_players(& $players)
{
	$first_player = array_shift($players);
	$last_player = array_pop($players);
	array_unshift($players, $last_player);
	array_unshift($players, $first_player);
}
