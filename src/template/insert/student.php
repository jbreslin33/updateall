<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../headers/header.php");

$query = "insert into users (username,password,first_name,last_name,role_id,admin_id,teacher_id) values (";

//$query .= "'2.anselm','p','justin','ritter',3,1,3);";
//$query .= "'";
//$xx
//$query = "INSERT INTO book VALUES ('$_POST[bookid]','$_POST[book_name]',
//'$_POST[author]','$_POST[publisher]','$_POST[dop]',
//'$_POST[price]')";

$query = "INSERT INTO users (username,password,first_name,last_name,role_id,admin_id,teacher_id) VALUES ('$_POST[username]','$_POST[password]',
'$_POST[first_name]','$_POST[last_name]','$_POST[role_id]','$_POST[admin_id]',
'$_POST[teacher_id]')";

$result = pg_query($query);

?>
</head>

<body>
<p1>Student added<p1>
<p1>WELCOME TO SHOW STUDENTS PAGE<p1>
<a href="../subject/chooser.php">Play Game</a> 
<a href="../main/main.php">MAIN PAGE</a> 
<a href="../edit/edit.php">EDIT PAGE</a> 
<a href="../select/users.php">SHOW MY STUDENTS</a> 

</body>
</html>

