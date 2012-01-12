
<html>
<body>

<?php
session_start();

// If the user is not logged in send him/her to the login form
if ($_SESSION["Login"] != "YES")
{
	header("Location: login_form.php");
}

$id = $_SESSION["id"];

//query string
$query = "select math_game_level ";
$query .= "from users ";
$query .= "where id = ";
$query .= $id;

$query .= ";";

echo "<h1> Query: $query </h1>";
?>



</body>
</html>
