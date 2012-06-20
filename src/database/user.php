<?php
session_start();
?>

<?php include("../database/db_connect.php"); ?>

<?php
	//db connection
	$conn = dbConnect();
	
	//query string 	
 	$query = "select id, math_level, english_level from users where username = '";
	$query .= $_SESSION["username"];
	$query .= "';"; 
   	
	//get db result
	$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

	//get numer of rows
   	$num = pg_num_rows($result);
	
	//close db connection as we have the only var we needed - the id
	pg_close();
	
	if ($num > 0)
	{
		//get the id from user table	
		$id = pg_Result($result, 0, 'id');
		$mathLevel = pg_Result($result, 0, 'math_level');
		$englishLevel = pg_Result($result, 0, 'english_level');
		
	}
?>		
	

<html>
<body>

<h1>This is the user page!</h1>

<a href="http://abcandyou.com/~jbreslin/updateall/src/template/subjects/chooser.php">
main screen
</a>

<p>

 get info from session vars:<br/>
 <?php echo "username = ". $_SESSION["username"]; ?><br/><br/>
 
 get info from database:<br/>
 <?php echo "id = ". $id; ?>

</p>
	

</body>
</html>



