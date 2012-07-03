<?php include("../login/check_login.php"); ?>
<?php include("../database/db_connect.php"); ?>

<?php


$conn = dbConnect();
echo "hello";


$query = "insert into levels_transactions (level_id,student_id) values ('";

$query .= $_SESSION["level_id"];
$query .= "','";
$query .= $_SESSION["student_id"];
$query .= "');";

echo "level_id:";
echo  $_SESSION["level_id"];
echo "<br>";
echo "<br>";
echo "student_id:";
echo  $_SESSION["student_id"];

//db call to update
//$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//now find out what new level is...
//---------------------------------------FIND LEVEL---------------------------
//this query could be more efficient maybe
/*
$query = "select advancement_time, level_id from levels_transactions where student_id = ";
$query .= $_SESSION["student_id"];
$query .= " ORDER BY advancement_time LIMIT 1";
$query .= ";";

 //get db result
                        $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                        dbErrorCheck($conn,$result);

                        //get numer of rows
                        $num = pg_num_rows($result);

                        if ($num > 0)
                        {
                                //get the id from user table
                                $last_completed_level_id = pg_Result($result, 0, 'level_id');

                                //set level_id
                                $_SESSION["last_completed_level_id"] = $level_id;
                        }
                        else
                        {
                                // no transaction in level_transactions so set level_id to 1
                                $_SESSION["last_completed_level_id"] = 1;
                        }
echo "last_completed_level_id:";
echo $_SESSION["last_completed_level_id"];
*/

/****************************** FIND NEXT LEVEL **********************************/
/*
$query = "DECLARE next_level_query SCROLL CURSOR FOR SELECT * FROM levels_transactions where level_id = ";
$query .= $_SESSION["last_completed_level_id"]; 
$query .= " order by levels;";

$query .= "fetch next from next_level_query;"; 


                        $result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());
                        dbErrorCheck($conn,$result);
      //get numer of rows
                        $num = pg_num_rows($result);

                        if ($num > 0)
                        {
                                //get the id from user table
                                $next_level_id = pg_Result($result, 0, 'level_id');

                                //set level_id
                                $_SESSION["next_level_id"] = $next_level_id;
                        }
                        else
                        {
                                // no transaction in level_transactions so set level_id to 1
                                $_SESSION["level_id"] = 1;
                        }
*/

//send player to the game page where he will be redirected.
//header("Location: ../template/math/chooser.php");

?>

