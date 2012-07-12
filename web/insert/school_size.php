<!DOCTYPE html>

<html>

<head>
<link rel="stylesheet" type="text/css" href="<?php getenv("DOCUMENT_ROOT")?>/updateall/src/css/green_style.css" />
</head>

<body>
<?php
session_start();
//db connection
include("../../database/db_connect.php");
$conn = dbConnect();

include(getenv("DOCUMENT_ROOT") . "/updateall/src/template/navigation/top_bar_links.php");
echo "<br>";
include(getenv("DOCUMENT_ROOT") . "/updateall/src/template/navigation/insert_links.php");
?>

<h2>Enter School Information :</h2>
<ul>
<form name="insert" action="school.php" method="POST" >
<h4>Number of Classes:</h4> 
<input type="text" value="10" name="number_of_classes" />
<br>
<h4>Approximate Number of Students Per Class:</h4>
<input type="text" value="30" name="number_of_students" />
<br>
<input type="submit" value="Create School" />
</form>
</ul>

</body>
</html>
