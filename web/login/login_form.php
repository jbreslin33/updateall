<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<html>

<head>
	<title>Login</title>

</head>

<body>
<?php
	//start session
	session_start();

	//and set Login to NO
	$_SESSION["Login"] = "NO";

      	$mess = $_GET["message"];
	
	if ($mess == "no_periods")
	{
		echo "No Periods";
	}
	if ($mess == "one_period")
	{
		echo "one period";
	}
	if ($mess == "too_many_periods")
	{
		echo "No username should contain 2 periods. Try again.";
	}
	if ($mess == "no_school")
	{
		echo "No School, try again.";
	}
	if ($mess == "no_user")
	{
		echo "No user try again.";
	}
	if ($mess == "user")
	{
		echo "we have a user.";
	}
	if ($mess == "no_admin")
	{
		echo "No admin try again.";
	}
	if ($mess == "no_teacher")
	{
		echo "No teacher try again.";
	}
	if ($mess == "no_student")
	{
		echo "No student try again.";
	}

?>
	<p><b> PLEASE LOGIN: </p></b>
	<form method="post" action="/web/login/login.php">

	<p>Username: <input type="text" name="username" /></p>
	<p>Password: <input type="text" name="password" /></p>

	<p><input type="submit" value="Log In" /></p>

	</form>

	<p><b> OR SIGN UP: </p></b>
	
	<form method="post" action="/web/signup/signup.php">

	<p>Username: <input type="text" name="schoolname" /></p>
	<p>Password: <input type="text" name="password" /></p>

	<p><input type="submit" value="Sign Up" /></p>

	</form>
	
</body>

</html>

