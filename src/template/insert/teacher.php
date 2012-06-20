<?php 
include("../headers/header.php");
include("../links/links.php");

//we first need some info, we need to know the username of admin 
$admin = $_SESSION["username"]; 

//first we need all the passwords then we can pick one at random
$query = "select password from passwords;";
$result = pg_query($query);
dbErrorCheck($conn,$result);

$numberOfRows = pg_num_rows($result);
$randomNumber = rand(0,$numberOfRows);
$password = pg_fetch_result($result, $randomNumber, password);

//next we need to know what user we are up to for this admin
$query = "select username from users where admin = '$admin';";
$result = pg_query($query);
dbErrorCheck($conn,$result);

$numberOfRows = pg_num_rows($result);
//add number of rows + 1 to get next number. This is based off the premise that we do not EVER delete user rows only deactivate them. 
$userExtensionNumber = $numberOfRows;
//now let's combine admin username and userExtensionNumber to come up with a new username.
$newUsername = $userExtensionNumber;
$newUsername .= ".";
$newUsername .= $admin; 

//let's actually add the user
$query = "INSERT INTO users (username,password,role,admin,teacher) VALUES ('$newUsername','$password',
'Teacher','$admin',
'$admin')";

$result = pg_query($query);
dbErrorCheck($conn,$result);

//go to success page
header("Location: ../select/teacher.php");

?>
</head>
</html>

