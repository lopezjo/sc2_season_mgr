<?php

include_once 'common.php';
include_once 'match_helpers.php';

/*
 * Add routes
 */
getRoute()->get('/seasons/(\d+)/divisions/(\d+)/matches/(\d+)', 'get_match');
getRoute()->put('/seasons/(\d+)/divisions/(\d+)/matches/(\d+)', 'update_match');
getRoute()->delete('/seasons/(\d+)/divisions/(\d+)/matches/(\d+)', 'delete_match');

/*
 * Implementation of resource
 */

function get_match($season_id, $division_id, $match_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of matches
	*/
	if ($result = $db_connection->query("SELECT * FROM matches WHERE match_id=$match_id"))
	{
		if ($result->num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{
			while ($row = $result->fetch_assoc())
			{
				match_row_to_response($db_connection, $row);
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

function delete_match($season_id, $division_id, $match_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();
	
	if ($result = $db_connection->query("SELECT * FROM matches WHERE match_id=$match_id"))
	{
		$num_rows = $result->num_rows;
		$result->free();
		
		if ($num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{
			$result = $db_connection->query("DELETE FROM matches WHERE match_id=$match_id");
			http_response_code(204);
		}
	}
	
	if (!$result)
	{
		http_response_code(400);
		echo "Failed query to MySQL: (" . $db_connection->errno . ") " . $db_connection->error;
	}
	
	db_close($db_connection);
}

function update_match($season_id, $division_id, $match_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();
    
	$json = file_get_contents("php://input");
	$match = json_decode($json, TRUE);
			
	try 
	{
		check_match($match);
	
		$division = $match['division'];
		$player1 = $match['player1'];
		$player2 = $match['player2'];
		$winner = $match['winner'];
		$map = $match['map'];
								
		try 
		{
			/*
			 * Check that the specified resource exists
			 */			
			if (!$result = $db_connection->query("SELECT * FROM matches WHERE match_id=$match_id"))
			{
				throw new Exception($db_connection->error, $db_connection->errno);
			}
			$num_rows = $result->num_rows;
			$result->free();
			
			if ($num_rows < 1)
			{
				http_response_code(404);
				return;
			}		

			/*
			 * Start a transaction and update rows
			 */
					
			$db_connection->autocommit(FALSE);
			$update = "UPDATE matches SET " .
					  "division_id=" . get_sql_value($division, 'id') . "," .
					  "player1_id=" . get_sql_value($player1, 'id') . "," .
					  "player2_id=" . get_sql_value($player2, 'id') . "," .
					  "winner_id=" . get_sql_value($winner, 'id') . "," .
					  "map_id=" . get_sql_value($map, 'id') . " " .
					  "WHERE match_id=$match_id";
				
			if (!$result = $db_connection->query($update))
			{
				throw new Exception($db_connection->error, $db_connection->errno);
			}
						
			$db_connection->commit();
		}
		catch (Exception $e)
		{
			http_response_code(400);
			echo "Failed query to MySQL: (" . $e->getCode() . ") " . $e->getMessage();
		
			$db_connection->rollback();
		}
		$db_connection->autocommit(TRUE);
	}
	catch(Exception $e)
	{
		http_response_code(400);
		echo $e->getMessage();
	}			
		
	db_close($db_connection);
}




