<?php

//db connection
$db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");

//query string
$query = "select url ";
$query .= "from math_games ";
$query .= "where level = ";
$query .= $math_game_id;
$query .= ";";

//get db restult
$dbResult = pg_query($query);

//check for db error
if (!$dbResult)
{
	die("Database error...math_game_url");
}

//get numer of rows
$num = pg_num_rows($dbResult_user);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
	//let's grab the math_game_level as we will use it next to find out the url of the game... 
        $url = pg_Result ($dbResult, 0, 'url');
}

?>
