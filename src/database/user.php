<?php
session_start();
?>

<html>
<body>

<h1>This is the user page!</h1>

<a href="http://abcandyou.com/~jbreslin/updateall/src/template/choosers/chooser_subject.php">
main screen
</a>

<p>

 <?php echo "username:". $_SESSION["username"]; ?>

</p>
	

</body>
</html>



