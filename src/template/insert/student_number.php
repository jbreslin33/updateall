<?php 
include("../headers/header.php");
include("../../database/insert_into_users.php"); 
include("../../database/insert_into_students.php"); 
include("../../database/insert_first_level_transaction.php"); 
include("../../database/select_user_id.php"); 

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
  //insert user

                insertIntoUsers($conn,$newUsername, $password, $_SESSION["school_id"]);
                $new_user_id = selectUserID($conn, $_SESSION["school_id"],$newUsername,$password);


                //insert student
                insertIntoStudents($conn,$new_user_id);

                insertFirstLevelTransaction($conn,$new_user_id);




//go to success page
header("Location: ../select/student.php");

?>
</head>
</html>

