<?php

function link_row_to_response($row, $href_prefix)
{
		echo '{';
		echo '"id": '   . json_encode($row['link_id'], JSON_NUMERIC_CHECK) . ',';
		echo '"href": ' . json_encode(BASE_URI . $href_prefix . '/links/' . $row['link_id']) . ',';
		echo '"url": '  . json_encode($row['link_url']) . ',';
		echo '"desc": ' . json_encode($row['link_desc']);
		echo '}';
}

function get_links($fkey_col, $fkey_id, $href_prefix)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of maps
	*/
	if ($result = $db_connection->query("SELECT * FROM links WHERE $fkey_col=$fkey_id"))
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

			link_row_to_response($row, $href_prefix);
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

function add_link($fkey_col, $fkey_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	$json = file_get_contents("php://input");
	$link = json_decode($json, TRUE);

	/*
	 * If missing fields critical field then return error
	*/
	$required = array('url');
	if (($valid = validate_required($link, $required)) === TRUE)
	{
		$insert = 'INSERT INTO links (link_url, link_desc, ' . $fkey_col . ') ' .
				'VALUES (' .
				get_sql_value($link, 'url') . ',' .
				get_sql_value($link, 'desc') . ',' .
				"'" . $fkey_id . "'" . ')';

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

function get_link($link_id, $fkey_col, $fkey_id, $href_prefix)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	/*
	 * Get the list of maps
	*/
	$query = "SELECT * FROM links WHERE link_id=$link_id AND $fkey_col=$fkey_id";
	if ($result = $db_connection->query($query))
	{
		if ($result->num_rows < 1)
		{
			http_response_code(404);
		}
		else
		{
			while ($row = $result->fetch_assoc())
			{
				link_row_to_response($row, $href_prefix);
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

function delete_link($link_id, $fkey_col, $fkey_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	$query = "SELECT * FROM links WHERE link_id=$link_id AND $fkey_col=$fkey_id";
	if ($result = $db_connection->query($query))
		{
		$num_rows = $result->num_rows;
		$result->free();

		if ($num_rows < 1)
		{
			http_response_code(404);
		}
		else
		{
			$result = $db_connection->query("DELETE FROM links WHERE link_id=$link_id");
		}
	}

	if (!$result)
	{
		http_response_code(400);
		echo "Failed query to MySQL: (" . $db_connection->errno . ") " . $db_connection->error;
	}

	db_close($db_connection);
}


function update_link($link_id, $fkey_col, $fkey_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();

	$json = file_get_contents("php://input");
	$link = json_decode($json, TRUE);

	$query = "SELECT * FROM links WHERE link_id=$link_id AND $fkey_col=$fkey_id";
	if ($result = $db_connection->query($query))
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
			$required = array('url');
			if (($valid = validate_required($link, $required)) === TRUE)
			{
				$update = "UPDATE links SET " .
						  "link_url=" . get_sql_value($link, 'url') . "," .
						  "link_desc=" . get_sql_value($link, 'desc') .
						  " WHERE link_id=$link_id";

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

