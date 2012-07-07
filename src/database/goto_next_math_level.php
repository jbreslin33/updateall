<?php include("../login/check_login.php"); ?>
<?php include("../database/db_connect.php"); ?>
<?php include("../database/set_level_session_variables.php"); ?>

<?php

$conn = dbConnect();

$query = "insert into levels_transactions (advancement_time, level_id,student_id) values (current_timestamp,'";
$query .= $_SESSION["next_level_id"];
$query .= "','";
$query .= $_SESSION["student_id"];
$query .= "');";

//db call to update
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

setLevelSessionVariables($conn);

//send player to the game page where he will be redirected.
header("Location: ../template/game/chooser.php");

?>

