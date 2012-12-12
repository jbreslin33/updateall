<?php 
//start session
session_start();

//db connection
include(getenv("DOCUMENT_ROOT") . "/src/database/db_connect.php"); 
$conn = dbConnect();

include(getenv("DOCUMENT_ROOT") . "/src/database/get_random_password.php"); 
include(getenv("DOCUMENT_ROOT") . "/src/database/get_next_usernumber.php"); 
include(getenv("DOCUMENT_ROOT") . "/src/database/insert_into_users.php"); 
include(getenv("DOCUMENT_ROOT") . "/src/database/select_user_id.php"); 
include(getenv("DOCUMENT_ROOT") . "/src/database/insert_into_teachers.php"); 
include(getenv("DOCUMENT_ROOT") . "/src/database/insert_into_students.php"); 
include(getenv("DOCUMENT_ROOT") . "/src/database/insert_first_level_transaction.php"); 

//loop thru classes
//$number_of_classes = $_POST["number_of_classes"];
$number_of_students = 10;

	//now loop thru and add a class of students..
	//$number_of_students = $_POST["number_of_students"]; 
	for ($i = 0; $i < $number_of_students; $i++)
	{
		//************ class student ********************
		//get a password
		$password = getRandomPassword($conn);

		//get a username
		//$newUsername = getNextUsernumber($conn);
		$newUsername = $i;

		//let's actually add the user
		insertIntoUsers($conn,$newUsername, $password, $_SESSION["school_id"]);

		//get new user id
		$new_student_id = selectUserID($conn, $_SESSION["school_id"],$newUsername,$password);

		//insert student
		//insertIntoStudents($conn,$new_student_id,$new_teacher_id);
		insertIntoStudents($conn,$new_student_id,1);

		//insert first transaction for levels to lowest level
		insertFirstLevelTransaction($conn,$new_student_id);
	}

//go to success page
header("Location: /web/select/student.php");

?>

