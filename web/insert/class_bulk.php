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


$file_handle = fopen("viso.txt", "r");

while (!feof($file_handle))
{
        $line = fgets($file_handle);

	//to protect against end of file for reals
	if (!feof($file_handle))
 	{
        	$pieces = explode(":",$line);

		$newUsername = $pieces[0];
		$password    = trim($pieces[1]);

		//let's actually add the user
		insertIntoUsers($conn,$newUsername, $password, $_SESSION["school_id"]);

		//get new user id
		$new_student_id = selectUserID($conn, $_SESSION["school_id"],$newUsername,$password);

		//insert student
		insertIntoStudents($conn,$new_student_id,$_SESSION["school_id"]);

		//insert first transaction for levels to lowest level
		insertFirstLevelTransaction($conn,$new_student_id);
	}
}

//go to success page
header("Location: /web/select/student.php");

?>

