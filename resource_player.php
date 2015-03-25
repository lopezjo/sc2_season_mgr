<?php

include_once 'common.php';

/*
 * Add routes
 */
getRoute()->get('/players/(\d+)', 'get_player');
getRoute()->put('/players/(\d+)', 'update_player');
getRoute()->delete('/players/(\d+)', 'delete_player');

/*
 * Implementation of resource
 */

function get_player($player_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of players
	*/
	if ($result = $db_connection->query("SELECT * FROM players WHERE player_id=$player_id"))
	{
		if ($result->num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{
			while ($row = $result->fetch_assoc())
			{
				echo '{';
				echo '"id": ' . json_encode($row['player_id'], JSON_NUMERIC_CHECK) . ',';
				echo '"parent": "' . BASE_URI . '/players",';
				echo '"name": ' . json_encode($row['player_name']) ;
				echo '}';
				
			}
		}
		$result->free();
	}
	else
	{
		http_response_code(400);	
		echo "Failed query to MySQL: (" . $db_connection->errno . ") " . $db_connection->error;
	}

	db_close($db_connection);
}

function delete_player($player_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	if ($result = $db_connection->query("SELECT * FROM players WHERE player_id=$player_id"))
	{
		$num_rows = $result->num_rows;
		$result->free();
		
		if ($num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{	
			$result = $db_connection->query("DELETE FROM players WHERE player_id=$player_id");
		}
	}
	
	if (!$result)
	{
		http_response_code(400);
		echo "Failed query to MySQL: (" . $db_connection->errno . ") " . $db_connection->error;
	}
	
	db_close($db_connection);
}


function update_player($player_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	$json = file_get_contents("php://input");
	$player = json_decode($json, TRUE);
	
	if ($result = $db_connection->query("SELECT * FROM players WHERE player_id=$player_id"))
	{
		$num_rows = $result->num_rows;
		$result->free();
		
		if ($num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{
			/*
			 * If missing critical field then return error
			*/
			$required = array('name');
			if (($valid = validate_required($player, $required)) === TRUE)
			{
				$update = "UPDATE players SET " .
						"player_name=" . get_sql_value($player, 'name') . " " .
						"WHERE player_id=$player_id";
			
				$result = $db_connection->query($update);
			}
			else
			{
				http_response_code(400);
				echo "Failed due to missing field: ($valid)";
			}			
		}
	}

	if (!$result)
	{
		http_response_code(400);
		echo "Failed query to MySQL: (" . $db_connection->errno . ") " . $db_connection->error;
	}
	
	db_close($db_connection);
}




