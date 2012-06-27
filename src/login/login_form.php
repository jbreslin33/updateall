<html>

<head>
	<title>Login</title>

</head>

<body>
<?php
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

?>
	<p><b> PLEASE LOGIN: </p></b>
	<form method="post" action="login.php">

	<p>Username: <input type="text" name="username" /></p>
	<p>Password: <input type="text" name="password" /></p>

	<p><input type="submit" value="Log In" /></p>

	</form>

	<p><b> OR SIGN UP: </p></b>
	
	<form method="post" action="../signup/signup.php">

	<p>Username: <input type="text" name="username" /></p>
	<p>Password: <input type="text" name="password" /></p>

	<p><input type="submit" value="Sign Up" /></p>

	</form>
	
</body>

</html>

