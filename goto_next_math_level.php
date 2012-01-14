<?php include("check_login.php"); ?>

<?php

//db connection
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") or die('Could not connect: ' . pg_last_error());

//------math game level-----------------------------------------------

$math_game_level = $_SESSION["math_game_level"];
$math_game_level = $math_game_level + 100;

//query string
//$query = "select math_game_level ";
//$query .= "from users ";
//$query .= "where id = ";
//$query .= $_SESSION["id"];
//$query .= ";";
//update users set math_game_level = 200 where id = 3;
$query = "update users set math_game_level = ";
$query .= $math_game_level;
$query .= " where id = ";
$query .= $_SESSION["id"];
$query .= ";"; 

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

header("Location: game.php");

?>

