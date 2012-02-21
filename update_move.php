<?php include("check_login.php"); ?>

<?php

$moveKey=$_GET["moveKey"];

//db connection
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") or die('Could not connect: ' . pg_last_error());

//------math game level-----------------------------------------------

//update the level +100
//$math_game_level = $_SESSION["math_game_level"];
//$math_game_level = $math_game_level + 100;

//query 
$query = "update users set move_key = ";
$query .= $moveKey;
$query .= " where id = ";
$query .= $_SESSION["id"];
$query .= ";"; 

//db call to update
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

$query = "select move_key from users where id = ";
$query .= $_SESSION["id"];
$query .= ";";


$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
$newMoveKey = pg_Result ($result, 0, 'move_key');
echo $newMoveKey;
//$_SESSION["math_game_level"] = $math_game_level;

//send player to the game page where he will be redirected.
//header("Location: game_chooser.php");

?>

