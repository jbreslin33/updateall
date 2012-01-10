<?php

//db connection
$db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");

//query string
$query = "select *";
$query .= " from users ";
$query .= "where id = ";
$query .= $_POST["id"];
$query .= ";";

//get db restult
$dbResult_user = pg_query($query);

//check for db error
if (!$dbResult_user)
{
	die("Database error...");
}

//get numer of rows
$num = pg_num_rows($dbResult_user);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
	//let's grab the math_game_level as we will use it next to find out the url of the game... 
        $math_game_level = pg_Result ($dbResult_user, 0, 'math_game_level');
}





//send user to his game_url             
header("Location: $game_url");

?>
