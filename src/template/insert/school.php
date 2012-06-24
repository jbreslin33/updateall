<?php 
include("../headers/header.php");

//we first need some info, we need to know the username of admin 
$school_name = $_SESSION["school_name"]; 
$school_id = $_SESSION["school_id"]; 


$number_of_classes = $_POST["number_of_classes"];

for ($c = 0; $c < $number_of_classes; $c++)
{


//--------------- ADD TEACHER---------------------------

//first we need all the passwords then we can pick one at random
$query = "select password from passwords;";
$result = pg_query($conn,$query);
dbErrorCheck($conn,$result);
$numberOfRows = pg_num_rows($result);
$randomNumber = rand(0,$numberOfRows);
$password = pg_fetch_result($result, $randomNumber, password);

//next we need to know what user we are up to for this school
$query = "select username from users where school_id = $school_id;";
$result = pg_query($query);
dbErrorCheck($conn,$result);
$numberOfRows = pg_num_rows($result);

//add number of rows + 1 to get next number.
// This is based off the premise that we do not EVER delete user rows only deactivate them.
$userExtensionNumber = $numberOfRows;

//now let's combine school_name and userExtensionNumber to come up with a new username.
$newUsername = $userExtensionNumber;
$newUsername .= ".";
$newUsername .= $school_name;

//let's actually add the user
$query = "INSERT INTO users (username,password,school_id) VALUES ('$newUsername','$password',";
$query .= $school_id;
$query .= ");";
$result = pg_query($query);

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
        echo "no teacher id";
}

//now we need to insert into teachers table
$query = "INSERT INTO teachers (user_id) VALUES (";
$query .= $new_id;
$query .= ");";
$result = pg_query($query);
dbErrorCheck($conn,$result);

//now we need the id from teacher table so we can use it on student inserts below
$query = "select id from teachers where user_id = $new_id;";
$result = pg_query($query);
dbErrorCheck($conn,$result);

//get numer of rows
$num = pg_num_rows($result);
$new_teacher_id;

// if there is a row then the username and password pair exists
if ($num > 0)
{
        //get the id from user table
        $new_teacher_id = pg_Result($result, 0, 'id');

}
else
{
        echo "no teacher id";
}



//--------------- END ADD TEACHER---------------------------



//--------------- ADD STUDENTS---------------------------
$number_of_students = $_POST["number_of_students"]; 
for ($i = 0; $i < $number_of_students; $i++)
{


//first we need all the passwords then we can pick one at random
$query = "select password from passwords;";
$result = pg_query($conn,$query);
dbErrorCheck($conn,$result);
$numberOfRows = pg_num_rows($result);
$randomNumber = rand(0,$numberOfRows);
$password = pg_fetch_result($result, $randomNumber, password);

//next we need to know what user we are up to for this school 
$query = "select username from users where school_id = $school_id;";
$result = pg_query($query);
dbErrorCheck($conn,$result);
$numberOfRows = pg_num_rows($result);

//add number of rows + 1 to get next number.
// This is based off the premise that we do not EVER delete user rows only deactivate them. 
$userExtensionNumber = $numberOfRows;

//now let's combine school_name and userExtensionNumber to come up with a new username.
$newUsername = $userExtensionNumber;
$newUsername .= ".";
$newUsername .= $school_name; 

//let's actually add the user
$query = "INSERT INTO users (username,password,school_id) VALUES ('$newUsername','$password',";
$query .= $school_id;
$query .= ");";
$result = pg_query($query);
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
$query = "INSERT INTO students (user_id,teacher_id) VALUES (";
$query .= $new_id;
$query .= ",";
$query .= $new_teacher_id;
$query .= ");";
$result = pg_query($query);
dbErrorCheck($conn,$result);

}

//--------------- END ADD STUDENTS---------------------------
}

//go to success page
header("Location: ../select/student.php");

?>
</head>
</html>

