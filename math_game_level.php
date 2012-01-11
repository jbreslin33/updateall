<?php

// Start up your PHP Session
session_start();

//db connection
$db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");

//query string
$query = "select math_game_level ";
$query .= "from users ";
$query .= "where id = ";
$query .= $_SESSION["id"];

$query .= ";";

//get db restult
$dbResult = pg_query($query);

//check for db error
if (!$dbResult)
{
	die("Database error math_game_level...");
}

//get numer of rows
$num = pg_num_rows($dbResult);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
	//let's grab the math_game_level as we will use it next to find out the url of the game... 
        $math_game_level = pg_Result ($dbResult, 0, 'math_game_level');
}

?>
