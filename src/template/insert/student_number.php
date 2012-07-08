<?php 
include("../headers/header.php");

session_start();

//first we need all the passwords then we can pick one at random
$query = "select password from passwords;";
$result = pg_query($conn,$query);
dbErrorCheck($conn,$result);
$numberOfRows = pg_num_rows($result);
$randomNumber = rand(0,$numberOfRows);
$password = pg_fetch_result($result, $randomNumber, password);

//next we need to know what user we are up to for this school 
$query = "select username from users where school_id = ";
$query .= $_SESSION["school_id"];
$query .= ";";

$result = pg_query($query);
dbErrorCheck($conn,$result);
$numberOfRows = pg_num_rows($result);

//add number of rows + 1 to get next number.
// This is based off the premise that we do not EVER delete user rows only deactivate them. 
$userExtensionNumber = $numberOfRows;

//now let's combine school_name and userExtensionNumber to come up with a new username.
$newUsername = $userExtensionNumber;

//let's actually add the user




//go to success page
header("Location: ../select/student.php");

?>
</head>
</html>

