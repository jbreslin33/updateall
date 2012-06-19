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


<h2>Enter Homeroom Size:</h2>
<ul>
<form name="insert" action="homeroom.php" method="POST" >
<input type="text" value="35" name="number_of_students" />
<br>
<input type="submit" value="Create Home Room" />
</form>
</ul>

</body>
</html>
