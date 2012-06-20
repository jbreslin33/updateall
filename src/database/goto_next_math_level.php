<?php include("../login/check_login.php"); ?>

<?php

//db connection
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") or die('Could not connect: ' . pg_last_error());

//query 
$query = "update users set math_level = ";
$query .= $_SESSION["math_next_level"];
$query .= " where username = '";
$query .= $_SESSION["username"];
$query .= "';"; 

//db call to update
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

$_SESSION["math_level"] = $_SESSION["math_next_level"];

//send player to the game page where he will be redirected.
header("Location: ../template/math/chooser.php");

?>

