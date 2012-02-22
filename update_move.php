<?php

$moveKey=$_GET["moveKey"];

//db connection
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") or die('Could not connect: ' . pg_last_error());

//query 
$query = "update users set move_key = ";
$query .= $moveKey;
$query .= " where id = ";
$query .= $_SESSION["id"];
$query .= ";"; 

//db call to update
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

?>

