<?php

function insertIntoStudents($conn,$user_id)
{
 		//--------------------INSERT INTO TEACHERS----------------
                //query string 
                $query = "INSERT INTO students (user_id) VALUES (";
                $query .= $user_id;
                $query .= ");";
                
                // insert into users......
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);
                
                //----------------TEACHER CHECK----------------------------------------------
                //is this user a student ? if so let's set some session vars
                //query string
                $query = "select id from students where id = ";
                $query .= $user_id;
                $query .= ";";

                //get db result
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);

                //get numer of rows
                $num = pg_num_rows($result);

                if ($num > 0)
                {
                        //get the id from user table
                        $student_id = pg_Result($result, 0, 'id');

			return $student_id;
                }
                else
                {
               		return 0; 
		}

}

?>
