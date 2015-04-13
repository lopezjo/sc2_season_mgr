<?php

include_once 'common.php';
include_once 'division_helpers.php';
include_once "round_helpers.php";

/*
 * Add routes
 */
getRoute()->get('/seasons/(\d+)/divisions/(\d+)/rounds/(\d+)', 'get_round');

/*
 * Implementation of resource
 */

function get_round($season_id, $division_id, $round_id)
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

		if ($round_id < 1 || $round_id > $player_count - 1)
		{
			http_response_code(404);
		}
		else 
		{
			for ($i = 0; $i < $player_count - 1; ++$i)
			{
				if ($round_id == $i + 1)
				{
					round_to_response($db_connection, $season_id, $division_id, $i + 1, $players);
					break;
				}
				shift_players($players);
			}
		}
	}
	catch (Exception $e)
	{
		http_response_code(400);
		echo "Failed query to MySQL: (" . $e->getCode() . ") " . $e->getMessage();
	}
	
	db_close($db_connection);
}



