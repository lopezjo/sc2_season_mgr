<?php

include_once 'common.php';

/*
 * Add routes
 */
getRoute()->get('/maps', 'get_maps');
getRoute()->post('/maps', 'add_map');

/*
 * Implementation of resource
 */

function get_maps()
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of maps
	*/
	if ($result = $db_connection->query("SELECT * FROM maps"))
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
				
			map_row_to_response($row);
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


function add_map()
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	$json = file_get_contents("php://input");
	$map = json_decode($json, TRUE);
	
	/*
	 * If missing fields critical field then return error
	*/
	$required = array('name');
	if (($valid = validate_required($map, $required)) === TRUE)
	{
		$insert = 'INSERT INTO maps (map_name) ' .
				'VALUES (' .
				get_sql_value($map, 'name') . ')';
	
		if (!$result = $db_connection->query($insert))
		{
			http_response_code(400);
			echo "Failed query to MySQL: (" . $db_connection->errno . ") " . $db_connection->error;
		}
		else 
		{
			$map_id = $db_connection->insert_id;
			header('Location: ' . get_map_href($map_id));
			http_response_code(201);			
		}
	}
	else
	{
		http_response_code(400);
		echo "Failed due to missing field: ($valid)";
	}
		
	db_close($db_connection);
}




