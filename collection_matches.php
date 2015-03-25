<?php

include_once 'common.php';
include_once 'match_helpers.php';

/*
 * Add routes
 */
getRoute()->get('/seasons/(\d+)/divisions/(\d+)/matches', 'get_matches');
getRoute()->post('/seasons/(\d+)/divisions/(\d+)/matches', 'add_match');

/*
 * Implementation of resource
 */

function get_matches($season_id, $division_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of divisions
	*/
	if ($result = $db_connection->query("SELECT * FROM matches WHERE division_id=$division_id"))
	{
		echo '[';
		$is_first = TRUE;
		while ($row = $result->fetch_assoc())
		{
			if (!$is_first)
			{
				echo ',';
			}
			$is_first = FALSE;
			match_row_to_response($db_connection, $row);
		}
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

function add_match($season_id, $division_id)
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
		
		/*
		 * Input looks good so start a transaction and add rows
		*/
		try
		{
			$db_connection->autocommit(FALSE);
			$db_connection->begin_transaction();
			
			$insert = 'INSERT INTO matches (division_id, player1_id, player2_id, ' .
					  'winner_id, map_id) VALUES (' .
					  get_sql_value($division, 'id') . ',' .
					  get_sql_value($player1, 'id') . ',' .
					  get_sql_value($player2, 'id') . ',' .
					  get_sql_value($winner, 'id') . ',' .
					  get_sql_value($map, 'id') . ')';
			
			if (!$result = $db_connection->query($insert))
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
		finally
		{
			$db_connection->autocommit(TRUE);
		}			
	}
	catch(Exception $e)
	{
		http_response_code(400);
		echo $e->getMessage();
	}
	
	db_close($db_connection);
}




