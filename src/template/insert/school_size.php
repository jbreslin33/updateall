<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../headers/header.php");
include("../links/links.php");

?>
</head>

<body>
<h2>Enter School Information :</h2>
<ul>
<form name="insert" action="school.php" method="POST" >
<h4>Number of Classes:</h4> 
<input type="text" value="25" name="number_of_classes" />
<br>
<h4>Approximate Number of Students Per Class:</h4>
<input type="text" value="35" name="number_of_students" />
<br>
<input type="submit" value="Create School" />
</form>
</ul>

</body>
</html>
