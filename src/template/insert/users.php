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


<h2>Enter information regarding book</h2>
<ul>
<form name="insert" action="insert_user.php" method="POST" >
<li>Book ID:</li><li><input type="text" name="bookid" /></li>
<li>Book Name:</li><li><input type="text" name="book_name" /></li>
<li>Author:</li><li><input type="text" name="author" /></li>
<li>Publisher:</li><li><input type="text" name="publisher" /></li>
<li>Date of publication:</li><li><input type="text" name="dop" /></li>
<li>Price (USD):</li><li><input type="text" name="price" /></li>
<li><input type="submit" /></li>
</form>
</ul>

</body>
</html>
