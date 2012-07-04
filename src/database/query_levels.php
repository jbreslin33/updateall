<?php


function setLevelSessionVariables($conn)
{
$query = "select advancement_time, level_id from levels_transactions where student_id = ";
$query .= $_SESSION["student_id"];
$query .= " ORDER BY advancement_time DESC LIMIT 1";
$query .= ";";

 //get db result
                        $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                        dbErrorCheck($conn,$result);

                        //get numer of rows
                        $num = pg_num_rows($result);

                        if ($num > 0)
                        {
                                //get the id from user table
                                $last_level_id = pg_Result($result, 0, 'level_id');

                                //set level_id
                                $_SESSION["last_level_id"] = $last_level_id;
                        }
                        else
                        {
                                // no transaction in level_transactions so set level_id to 1
                                echo "error no transactions";
                        }

}
?>
