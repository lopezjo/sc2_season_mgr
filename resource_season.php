<?php

include_once 'common.php';
include_once 'season_helpers.php';

/*
 * Add routes
 */
getRoute()->get('/seasons/(\d+)', 'get_season');
getRoute()->put('/seasons/(\d+)', 'update_season');
getRoute()->delete('/seasons/(\d+)', 'delete_season');

/*
 * Implementation of resource
 */

function get_season($season_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of seasons
	*/
	if ($result = $db_connection->query("SELECT * FROM seasons WHERE season_id=$season_id"))
	{
		if ($result->num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{
			while ($row = $result->fetch_assoc())
			{
				season_row_to_response($db_connection, $row);
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

function delete_season($season_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();
	
	if ($result = $db_connection->query("SELECT * FROM seasons WHERE season_id=$season_id"))
	{
		$num_rows = $result->num_rows;
		$result->free();
		
		if ($num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{
			$result = $db_connection->query("DELETE FROM seasons WHERE season_id=$season_id");
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

function update_season($season_id)
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
				
		try 
		{
			/*
			 * Check that the specified resource exists
			 */			
			if (!$result = $db_connection->query("SELECT * FROM seasons WHERE season_id=$season_id"))
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
			$update = "UPDATE seasons SET " .
					  "season_name=" . get_sql_value($season, 'name') . "," .
					  "season_start=" . get_sql_value($season, 'date') . "," .
					  "season_winner=" . get_sql_value($winner, 'id') . " " .
					  "WHERE season_id=$season_id";
				
			if (!$result = $db_connection->query($update))
			{
				throw new Exception($db_connection->error, $db_connection->errno);
			}

			/*
			 * Fix up season maps
			 */
			del_season_maps($db_connection, $season_id);
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




