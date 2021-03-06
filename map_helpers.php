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

function map_row_to_response($row)
{
	echo '{';
	echo '"id": '         . json_encode($row['map_id'], JSON_NUMERIC_CHECK) . ',';
	echo '"href": '       . json_encode(get_map_href($row['map_id'])) . ',';
	echo '"name": '       . json_encode($row['map_name']) . ',';
	echo '"links_href": ' . json_encode(BASE_URI . '/maps/' . $row['map_id'] . '/links') ;
	echo '}';

}

/*
 * Use when referencing a map
 */
function map_id_to_ref_response($db_connection, $map_id)
{
	echo '{';
	echo '"id": '    . json_encode($map_id, JSON_NUMERIC_CHECK) . ',';
	echo '"name": '  . json_encode(get_map_name($db_connection, $map_id)) . ',';
	echo '"href": '  . json_encode(get_map_href($map_id));
	echo '}';
}

function get_map_href($map_id)
{
	return BASE_URI . '/maps/' . $map_id;
}