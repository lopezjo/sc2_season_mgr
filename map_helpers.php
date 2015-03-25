<?php

function get_map_name($db_connection, $map_id)
{
	$map_name = NULL;
	if ($result = $db_connection->query("SELECT * FROM maps WHERE map_id=$map_id"))
	{
		if ($result->num_rows == 1)
		{
			while ($row = $result->fetch_assoc())
			{
				$map_name = $row['map_name'];
			}
		}
		$result->free();
	}
	return $map_name;
}

/*
 * Use when referencing a map
 */
function map_id_to_ref_response($db_connection, $map_id)
{
	echo '{';
	echo '"id": '    . json_encode($map_id, JSON_NUMERIC_CHECK) . ',';
	echo '"name": '  . json_encode(get_map_name($db_connection, $map_id)) . ',';
	echo '"href": '  . json_encode(BASE_URI . '/maps/' . $map_id);
	echo '}';
}