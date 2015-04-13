<?php

include_once 'common.php';

/*
 * Add routes
 */
getRoute()->get('/maps/(\d+)', 'get_map');
getRoute()->put('/maps/(\d+)', 'update_map');
getRoute()->delete('/maps/(\d+)', 'delete_map');

/*
 * Implementation of resource
 */

function get_map($map_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of maps
	*/
	if ($result = $db_connection->query("SELECT * FROM maps WHERE map_id=$map_id"))
	{
		if ($result->num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{
			while ($row = $result->fetch_assoc())
			{
				map_row_to_response($row);
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

function delete_map($map_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	if ($result = $db_connection->query("SELECT * FROM maps WHERE map_id=$map_id"))
	{
		$num_rows = $result->num_rows;
		$result->free();
		
		if ($num_rows < 1)
		{
			http_response_code(404);
		}
		else 
		{	
			$result = $db_connection->query("DELETE FROM maps WHERE map_id=$map_id");
		}
	}
	
	if (!$result)
	{
		http_response_code(400);
		echo "Failed query to MySQL: (" . $db_connection->errno . ") " . $db_connection->error;
	}
	
	db_close($db_connection);
}


function update_map($map_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	$json = file_get_contents("php://input");
	$map = json_decode($json, TRUE);
	
	if ($result = $db_connection->query("SELECT * FROM maps WHERE map_id=$map_id"))
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
			if (($valid = validate_required($map, $required)) === TRUE)
			{
				$update = "UPDATE maps SET " .
						"map_name=" . get_sql_value($map, 'name') . " " .
						"WHERE map_id=$map_id";
			
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




