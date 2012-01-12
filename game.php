
<html>
<body>

<?php
session_start();

// If the user is not logged in send him/her to the login form
if ($_SESSION["Login"] != "YES")
{
	header("Location: login_form.php");
}
//db connection
$conn = pg_connect("host=localhost dbname=abcandyou user=postgres password=mibesfat") or die('Could not connect: ' . pg_last_error());

$id = $_SESSION["id"];

//query string
$query = "select math_game_level ";
$query .= "from users ";
$query .= "where id = ";
$query .= $id;

$query .= ";";

echo "<h1> Query: $query </h1>";

//get db restult
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$num = pg_num_rows($result);

echo "<h1>  Number of Rows: $num </h1>";

// if there is a row then id exists it better be unique!
if ($num > 0)
{
	//$math_game_level = pg_result_seek($result, 0);
	$row = pg_fetch_row($result);	
	echo "<h1> math_game_level: $row[0] </h1>";
}

?>



</body>
</html>
