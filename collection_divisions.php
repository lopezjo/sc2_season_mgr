<?php

include_once 'common.php';
include_once 'division_helpers.php';

/*
 * Add routes
 */
getRoute()->get('/seasons/(\d+)/divisions', 'get_divisions');
getRoute()->post('/seasons/(\d+)/divisions', 'add_division');

/*
 * Implementation of resource
 */

function get_divisions($season_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of divisions
	*/
	if ($result = $db_connection->query("SELECT * FROM divisions WHERE season_id=$season_id"))
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
			division_row_to_response($db_connection, $row);
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

function add_division()
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
	
		/*
		 * Input looks good so start a transaction and add rows
		*/
		try
		{
			$db_connection->autocommit(FALSE);
			$db_connection->begin_transaction();
			$insert = 'INSERT INTO divisions (division_name, season_id) ' .
					'VALUES (' .
					get_sql_value($division, 'name') . ',' .
					get_sql_value($season, 'id') . ')';
			
			if (!$result = $db_connection->query($insert))
			{
				throw new Exception($db_connection->error, $db_connection->errno);
			}
	
			/*
			 * Now add division players
			 */
			$division_id = $db_connection->insert_id;
			update_division_players($db_connection, $division_id, $players);
				
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




