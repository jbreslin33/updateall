<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../headers/header.php");
//include("../links/links.php");

?>
</head>

<body>

<h6> This will create a class and a teacher for that class.</h6>
<h6> Teacher and students will be given a username and password automatically.</h6>
<h6> First and Last names can be filled in later.</h6>

<h2>Enter Class Size:</h2>
<ul>
<form name="insert" action="class.php" method="POST" >
<input type="text" value="35" name="number_of_students" />
<br>
<input type="submit" value="Create Class" />
</form>
</ul>

</body>
</html>
