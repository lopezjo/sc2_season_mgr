<?php

/*
 * Constants
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'psistorm');
define('DB_NAME', 'sc2_seasons');
define('BASE_URI', 'http://' . $_SERVER['HTTP_HOST'] . '/sc2_season_mgr');

global $WHITE_LIST;
$WHITE_LIST = array('::1', '127.0.0.1', 'localhost');