<?php

include_once 'common.php';
include_once 'player_helpers.php';

/*
 * Add routes
 */
getRoute()->get('/seasons/(\d+)/divisions/(\d+)/standings', 'get_standings');

/*
 * Implementation of resource
 */
function get_standings($season_id, $division_id)
{
	header('Content-Type: application/json');
	$db_connection = db_open();
	
	/*
	 * Get standings
	 */
	$query =
	'SELECT player_games.player, games, COALESCE(wins, 0) AS wins, COALESCE(games-wins, games) AS losses FROM ' .
		'(SELECT player, SUM(games) AS games FROM ' .
			'(SELECT player1_id AS player, COUNT(*) AS games FROM matches WHERE division_id=3 GROUP BY player1_id ' .
			'   UNION ' .
			' SELECT player2_id AS player, COUNT(*) AS games FROM matches WHERE division_id=3 GROUP BY player2_id) AS player_union ' .
		'GROUP BY player) AS player_games ' .
	'LEFT JOIN ' .
		'(SELECT winner_id as player, COUNT(*) As wins FROM matches WHERE division_id=3 GROUP BY winner_id) AS player_wins ' .
	'ON player_games.player=player_wins.player ' .
	'ORDER BY wins DESC';		
		
	if ($result = $db_connection->query($query))
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
	
			echo '{';
			echo '"player": ';
			echo player_id_to_ref_response($db_connection, $row['player']) . ',';
			echo '"wins": '   . json_encode($row['wins'], JSON_NUMERIC_CHECK) . ',';
			echo '"losses": ' . json_encode($row['losses'], JSON_NUMERIC_CHECK);
			echo '}';
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






