<html>

<head>
	<title>Login</title>

</head>

<body>
    header("Location: ../signup/signup_form.php?message=name_taken");
                }
                if ($space)
                {
                        header("Location: ../signup/signup_form.php?message=no_spaces");
                }
                if ($number)
                {
                        header("Location: ../signup/signup_form.php?message=no_numbers");
                }
                if ($period)
                {
                        header("Location: ../signup/signup_form.php?message=no_periods");
                }
                if ($_SESSION["school_name"] == '')
                {
                        header("Location: ../signup/signup_form.php?message=no_name");

<?php
      	$mess = $_GET["message"];

	if ($mess == "name_taken")
        {
                echo "That username is taken, Please try another.";
        }
        if ($mess == "no_numbers")
        {
                echo "You cannot use numbers in username. Please try again.";
        }
        if ($mess == "no_periods")
        {
                echo "You cannot use periods in signup. Please try again.";
        }
        if ($mess == "no_name")
        {
                echo "You forgot a username. Please fill one out.";
        }
?>
	<p><b> SIGN UP: </p></b>
	
	<form method="post" action="../signup/signup.php">

	<p>Username: <input type="text" name="schoolname" /></p>
	<p>Password: <input type="text" name="password" /></p>

	<p><input type="submit" value="Sign Up" /></p>

	</form>
	
</body>

</html>

