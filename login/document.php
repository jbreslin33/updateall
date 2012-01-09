<?php

	// Start up your PHP Session 
	session_start();

	// If the user is not logged in send him/her to the login form
	if ($_SESSION["Login"] != "YES") {
	  header("Location: form.php");
	}

	?>

	<html>
	<head>
	<title>Login</title>
	</head>

	<body>
	<h1>This document is protected</h1>

	<p>You can only see it if you are logged in.</p>
	</body>
	</html>

