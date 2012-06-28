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
$query = "INSERT INTO users (username,password,school_id) VALUES ('$newUsername','$password',";
$query .= $_SESSION["school_id"];
$query .= ");";
$result = pg_query($query);
dbErrorCheck($conn,$result);

//now we need to add to students table as well
$query = "select id from users where username = '$newUsername';";
$result = pg_query($query);
dbErrorCheck($conn,$result);

//get numer of rows
$num = pg_num_rows($result);
$new_id;

// if there is a row then the username and password pair exists
if ($num > 0)
{
	//get the id from user table
        $new_id = pg_Result($result, 0, 'id');

}
else
{
	echo "no student id";
}

//now we need to insert into students table
$query = "INSERT INTO students (user_id) VALUES (";
$query .= $new_id;
$query .= ");";
$result = pg_query($query);
dbErrorCheck($conn,$result);

//go to success page
header("Location: ../select/student.php");

?>
</head>
</html>

