<?php

function get_player_name($db_connection, $player_id)
{
	$player_name = NULL;
	if ($result = $db_connection->query("SELECT * FROM players WHERE player_id=$player_id"))
	{
		if ($result->num_rows == 1)
		{
			while ($row = $result->fetch_assoc())
			{
				$player_name = $row['player_name'];
			}
		}
		$result->free();
	}
	return $player_name;
}

function get_player_href($player_id)
{
	$href = NULL;
	if (!is_null($player_id))
	{
		$href = BASE_URI . '/players/' . $player_id;
	}
	return $href;
}

function player_row_to_response($row)
{
	echo '{';
	echo '"id": '         . json_encode($row['player_id'], JSON_NUMERIC_CHECK) . ',';
	echo '"href": '       . json_encode(BASE_URI . '/players/' . $row['player_id']) . ',';
	echo '"name": '       . json_encode($row['player_name']) . ',';
	echo '"links_href": ' . json_encode(BASE_URI . '/players/' . $row['player_id'] . '/links') ;
	echo '}';
	
}

/*
 * Use when referencing a player
 */
function player_id_to_ref_response($db_connection, $player_id)
{
	echo '{';
	echo '"id": '    . json_encode($player_id, JSON_NUMERIC_CHECK) . ',';
	echo '"name": '  . json_encode(get_player_name($db_connection, $player_id)) . ',';
	echo '"href": '  . json_encode(get_player_href($player_id));
	echo '}';
}