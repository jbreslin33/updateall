<?php

session_start();

// If the user is not logged in send him/her to the login form
if ($_SESSION["Login"] != "YES")
{
        header("Location: login_form.php");
}

?>
