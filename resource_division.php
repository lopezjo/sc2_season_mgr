<?php

include_once 'common.php';
include_once 'division_helpers.php';

/*
 * Add routes
 */
getRoute()->get('/seasons/(\d+)/divisions/(\d+)', 'get_division');
getRoute()->put('/seasons/(\d+)/divisions/(\d+)', 'update_division');
getRoute()->delete('/seasons/(\d+)/divisions/(\d+)', 'delete_division');

/*
 * Implementation of resource
 */

function get_division($season_id, $division_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of divisions
	*/
	if ($result = $db_connection->query("SELECT * FROM divisions WHERE division_id=$division_id"))
	{
		if ($result->num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{
			while ($row = $result->fetch_assoc())
			{
				division_row_to_response($db_connection, $row);
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

function delete_division($season_id, $division_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();
	
	if ($result = $db_connection->query("SELECT * FROM divisions WHERE division_id=$division_id"))
	{
		$num_rows = $result->num_rows;
		$result->free();
		
		if ($num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{
			$result = $db_connection->query("DELETE FROM divisions WHERE division_id=$division_id");
		}
	}
	
	if (!$result)
	{
		http_response_code(400);
		echo "Failed query to MySQL: (" . $db_connection->errno . ") " . $db_connection->error;
	}
	
	db_close($db_connection);
}

function update_division($season_id, $division_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();
    
	$json = file_get_contents("php://input");
	$division = json_decode($json, TRUE);
		
	try 
	{
		check_division($division);
	
		$season = $division['season'];
		$players = $division['players'];
						
		try 
		{
			/*
			 * Check that the specified resource exists
			 */			
			if (!$result = $db_connection->query("SELECT * FROM divisions WHERE division_id=$division_id"))
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
			$update = "UPDATE divisions SET " .
					  "division_name=" . get_sql_value($division, 'name') . "," .
					  "season_id=" . get_sql_value($season, 'id') . " " .
					  "WHERE division_id=$division_id";
				
			if (!$result = $db_connection->query($update))
			{
				throw new Exception($db_connection->error, $db_connection->errno);
			}

			/*
			 * Fix up division players
			 */
			update_division_players($db_connection, $division_id, $players);
				
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




