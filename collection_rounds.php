<?php

include_once 'common.php';
include_once 'division_helpers.php';
include_once "round_helpers.php";

/*
 * Add routes
 */
getRoute()->get('/seasons/(\d+)/divisions/(\d+)/rounds', 'get_rounds');

/*
 * Implementation of resource
 */
function get_rounds($season_id, $division_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();
	
	try 
	{
		$players = get_division_players($db_connection, $division_id);
		
		/* 
		 * An odd number of players means each round has a bye game
		 */
		$player_count = count($players);
		if ($player_count % 2 == 1)
		{
			$players[] = '-1';	// indicates the bye
			++$player_count;
		}
		
		echo '[';
		for ($i = 0; $i < $player_count - 1; ++$i)
		{
			if ($i > 0)
			{
				echo ',';
			}
				
			round_to_response($db_connection, $season_id, $division_id, $i + 1, $players);
			shift_players($players);
		}
		echo ']';
	}
	catch (Exception $e)
	{
		http_response_code(400);
		echo "Failed query to MySQL: (" . $e->getCode() . ") " . $e->getMessage();
	}
	
	db_close($db_connection);
}






