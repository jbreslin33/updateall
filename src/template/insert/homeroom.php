<?php 
include("../headers/header.php");

//before we loop we need a home_room
//we first need some info, we need to know the username of admin 
$admin = $_SESSION["username"]; 

//next we need to know what user we are up to for this admin
$query = "select * from home_rooms where admin = '$admin';";
$result = pg_query($query);
dbErrorCheck($conn,$result);

$numberOfRows = pg_num_rows($result);

//add number of rows + 1 to get next number. This is based off the premise that we do not EVER delete user rows only deactivate them. 
$home_roomExtensionNumber = $numberOfRows + 1;
//now let's combine admin username and userExtensionNumber to come up with a new username.
$newHomeRoomDescription = "HOME ROOM "; 
$newHomeRoomDescription .= $home_roomExtensionNumber;

$query = "insert into home_rooms (admin,teacher,description) values ('$admin','$admin','$newHomeRoomDescription');";
$result = pg_query($query);
dbErrorCheck($conn,$result);

$number_of_students = $_POST["number_of_students"];

for ($i = 0; $i < $number_of_students; $i++)
{

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
'Student','$admin',
'$admin')";

$result = pg_query($query);
dbErrorCheck($conn,$result);

//insert student into home_rooms_users
$query = "insert into home_rooms_users (admin,description,student) values ('$admin','$newHomeRoomDescription','$newUsername');";
$result = pg_query($query);
dbErrorCheck($conn,$result);


}
//go to success page
header("Location: ../edit/edit.php");

?>
</head>
</html>

