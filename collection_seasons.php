<?php

include_once 'common.php';
include_once 'season_helpers.php';

/*
 * Add routes
 */
getRoute()->get('/seasons', 'get_seasons');
getRoute()->post('/seasons', 'add_season');

/*
 * Implementation of resource
 */

function get_seasons()
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of seasons
	*/
	if ($result = $db_connection->query("SELECT * FROM seasons"))
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
			season_row_to_response($db_connection, $row);
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

function add_season()
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	$json = file_get_contents("php://input");
	$season = json_decode($json, TRUE);
		
	try
	{
		check_season($season);
		
		$winner = $season['winner'];
		$maps = $season['maps'];
		
		/*
		 * Input looks good so start a transaction and add rows
		 */
		try
		{
			$db_connection->autocommit(FALSE);
			$insert = 'INSERT INTO seasons (season_name, season_start, season_winner) ' .
					  'VALUES (' .
					  get_sql_value($season, 'name') . ',' .
					  get_sql_value($season, 'date') . ',' .
					  get_sql_value($winner, 'id') . ')';
			
			if (!$result = $db_connection->query($insert))
			{
				throw new Exception($db_connection->error, $db_connection->errno);
			}

			/*
			 * Now add season maps
			 */
			$season_id = $db_connection->insert_id;			
			add_season_maps($db_connection, $season_id, $maps);
			
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



