<?php

include_once 'common.php';
include_once 'player_helpers.php';
		
/*
 * Add routes
 */
getRoute()->get('/players', 'get_players');
getRoute()->post('/players', 'add_player');

/*
 * Implementation of resource
 */

function get_players()
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of players
	*/
	if ($result = $db_connection->query("SELECT * FROM players"))
	{
		echo '[';
		$is_first = TRUE;		
		/* fetch associative array */
		while ($row = $result->fetch_assoc())
		{
			if (!$is_first)
			{
				echo ',';
			}
			$is_first = FALSE;

			player_row_to_response($row);
		}

		/* free result set */
		$result->free();
		echo ']';			
	}
	else 
	{
		http_response_code(400);	
		echo "Failed query to MySQL: (" . $db_connection->errno . ") " . $db_connection->error;
	}
	
	db_close($db_connection);
}


function add_player()
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	$json = file_get_contents("php://input");
	$player = json_decode($json, TRUE);
	
	/*
	 * If missing fields critical field then return error
	*/
	$required = array('name');
	if (($valid = validate_required($player, $required)) === TRUE)
	{
		$insert = 'INSERT INTO players (player_name) ' .
				'VALUES (' .
				get_sql_value($player, 'name') . ')';
	
		if (!$result = $db_connection->query($insert))
		{
			http_response_code(400);
			echo "Failed query to MySQL: (" . $db_connection->errno . ") " . $db_connection->error;
		}
	}
	else
	{
		http_response_code(400);
		echo "Failed due to missing field: ($valid)";
	}
		
	db_close($db_connection);
}




