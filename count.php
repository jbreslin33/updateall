<html>
<body>

<?php

session_start();

// If the user is not logged in send him/her to the login form
if ($_SESSION["Login"] != "YES")
{
        header("Location: login_form.php");
}


echo "<h1> hello count </h1>";

$math_game_level = $_SESSION["math_game_level"];

//db connection
$db = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat");

//get game parameters...
//db connection
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") 
or die('Could not connect: ' . pg_last_error());

//query
$query = "select * ";
$query .= "from math_games ";
$query .= "where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";


echo "<h1> Query: $query </h1>";

echo "<h1> hello count </h1>";

?>

</body>
</html> 
