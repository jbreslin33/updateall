<?php
  //start new session
  session_start();
?>

<?php
include("stats.php");
 ?>

<p1>LINKS:<p1>
<br>
<br>

<p1>MAIN PAGE:<p1>
<br>
<a href="../main/main.php">MAIN PAGE</a>
<br>
<br>

<p1>GAMES:<p1>
<br>
<a href="../subject/chooser.php">Play Game</a>
<br>
<br>

<?php
if ($_SESSION["is_admin"] == "TRUE")
{
	include("inserts.php");
}
 ?>

<?php
include("selects.php");
 ?>



