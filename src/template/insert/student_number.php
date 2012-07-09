<?php 
include("../headers/header.php");
include("../../database/get_random_password.php"); 
include("../../database/get_next_usernumber.php"); 
include("../../database/insert_into_users.php"); 
include("../../database/select_user_id.php"); 
include("../../database/insert_into_students.php"); 
include("../../database/insert_first_level_transaction.php"); 

session_start();

//get a password
$password = getRandomPassword($conn);

//get a username
$newUsername = getNextUsernumber($conn);

//let's actually add the user
insertIntoUsers($conn,$newUsername, $password, $_SESSION["school_id"]);

//get new user id
$new_user_id = selectUserID($conn, $_SESSION["school_id"],$newUsername,$password);

//insert student
insertIntoStudents($conn,$new_user_id);

//insert first transaction for levels to lowest level
insertFirstLevelTransaction($conn,$new_user_id);

//go to success page
header("Location: ../select/student.php");

?>
</head>
</html>

