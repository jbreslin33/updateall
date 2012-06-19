<?php 
include("../headers/header.php");

$number_of_home_rooms = $_POST["number_of_home_rooms"];
$number_of_students = $_POST["number_of_students"];

for ($h = 0; $h < $number_of_home_rooms; $h++)
{ 



for ($i = 0; $i < $number_of_students; $i++)
{

//we first need some info, we need to know the username of admin, id of admin
$admin_id = $_SESSION["id"];
$admin_username = $_SESSION["username"]; 

//first we need all the passwords then we can pick one at random
$query = "select password from passwords;";
$result = pg_query($query);
$numberOfRows = pg_num_rows($result);
$randomNumber = rand(0,$numberOfRows);
$password = pg_fetch_result($result, $randomNumber, password);

//next we need to know what user we are up to for this admin
$query = "select username from users where admin_id = $admin_id;";
$result = pg_query($query);
$numberOfRows = pg_num_rows($result);
//add number of rows + 1 to get next number. This is based off the premise that we do not EVER delete user rows only deactivate them. 
$userExtensionNumber = $numberOfRows + 1;
//now let's combine admin username and userExtensionNumber to come up with a new username.
$newUsername = $userExtensionNumber;
$newUsername .= ".";
$newUsername .= $admin_username; 

//let's actually add the user
$query = "INSERT INTO users (username,password,role_id,admin_id,teacher_id) VALUES ('$newUsername','$password',
3,'$admin_id',
'$admin_id')";

$result = pg_query($query);

}


}
//go to success page
header("Location: ../edit/edit.php");

?>
</head>
</html>

