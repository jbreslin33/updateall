<?php

start_session();

//db connection
$db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");

$math_game_level = $_SESSION["math_game_level"];

//query string
$query = "select url ";
$query .= "from math_games ";
$query .= "where level = ";
$query .= $math_game_level;
$query .= ";";

//get db restult
$dbResult = pg_query($query);

//check for db error

if (!$dbResult)
{
	die("Database error...math_game_url");
}

//get numer of rows
$num = pg_num_rows($dbResult);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
	//let's grab the math_game_level as we will use it next to find out the url of the game... 
        $_SESSION["urly"] = pg_Result ($dbResult, 0, 'url');

	//echo "<h1> num </h1>";
}

?>
