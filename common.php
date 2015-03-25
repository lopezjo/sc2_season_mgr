<?php

include_once '../src/Epi.php';
include_once 'settings.php';

function db_open()
{
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	if ($db_connection->connect_errno) 
	{
		die("Failed to connect to MySQL: (" . $db_connection->connect_errno . ") " . 
			$db_connection->connect_error);
	}
	
	return $db_connection;
}

function db_close($db_connection)
{
	$db_connection->close();
}


function validate_required($array, $required)
{
	if (!isset($array))
	{
		return FALSE;
	}
	foreach ($required as $key)
	{
		if (!array_key_exists($key, $array))
		{
			return $key;
		}
	}
	return TRUE;
}

function get_sql_value($array, $key)
{
	if (isset($array[$key]))
	{
		return "'" . $array[$key] . "'";
	}
	else
	{
		return 'NULL';
	}
}
