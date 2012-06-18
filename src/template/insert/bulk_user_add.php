<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../headers/header.php");

?>
</head>

<body>
<p1>WELCOME TO SHOW STUDENTS PAGE<p1>
<a href="../subject/chooser.php">Play Game</a> 
<a href="../main/main.php">MAIN PAGE</a> 
<a href="../edit/edit.php">EDIT PAGE</a> 
<a href="../select/users.php">SHOW MY STUDENTS</a> 


<h2>Enter User information:</h2>
<ul>
<form name="insert" action="insert_user.php" method="POST" >
<li>username:</li><li><input type="text" name="username" /></li>
<li>password:</li><li><input type="text" name="password" /></li>
<li>first_name:</li><li><input type="text" name="first_name" /></li>
<li>last_name:</li><li><input type="text" name="last_name" /></li>
<li>role_id:</li><li><input type="text" name="role_id" /></li>
<li>admin_id:</li><li><input type="text" name="admin_id" /></li>
<li>teacher_id:</li><li><input type="text" name="teacher_id" /></li>
<li><input type="submit" /></li>
</form>
</ul>

</body>
</html>
