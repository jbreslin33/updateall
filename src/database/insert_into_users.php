<?php

function insertIntoUsers($conn,$username,$password,$school_id)
{
		//--------------------INSERT INTO USERS----------------
                //query string
                $query = "INSERT INTO users (username, password, school_id) VALUES ('";
                $query .= $username;
                $query .= "','";
                $query .= $password;
                $query .= "',";
                $query .= $school_id;
                $query .= ");";

                // insert into users......
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);
}

function insertIntoUsersWithFullName($conn,$username,$password,$school_id,$first_name,$middle_name,$last_name)
{
		//--------------------INSERT INTO USERS----------------
                //query string
                $query = "INSERT INTO users (username, password, school_id, first_name, middle_name, last_name) VALUES ('";
                $query .= $username;
                $query .= "','";
                $query .= $password;
                $query .= "',";
                $query .= $school_id;
                $query .= ",'";
                $query .= $first_name;
                $query .= "','";
                $query .= $middle_name;
                $query .= "','";
                $query .= $last_name;
                $query .= "'";
                $query .= ");";

                // insert into users......
                $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                dbErrorCheck($conn,$result);
}

?>
