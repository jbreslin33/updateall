<?php include("check_login.php"); ?>

<?php

//db connection
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") or die('Could not connect: ' . pg_last_error());

//------math game level-----------------------------------------------

//update the level +100
$math_game_level = $_SESSION["math_game_level"];
$math_game_level = $math_game_level + 100;

//query 
$query = "update users set math_game_level = ";
$query .= $math_game_level;
$query .= " where id = ";
$query .= $_SESSION["id"];
$query .= ";"; 

//db call to update
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//send player to the game page where he will be redirected.
header("Location: game.php");

?>

