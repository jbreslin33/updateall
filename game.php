<?php
session_start();

// If the user is not logged in send him/her to the login form
if ($_SESSION["Login"] != "YES")
{
	header("Location: login_form.php");
}
$theid = $_SESSION["id"];

?>

<html>
<body>

<?php include("math_game_level.php"); ?>

<?php include("math_game_url.php"); ?>

//send user to his game url
header("Location: $url");

</html>
</body>

?>
