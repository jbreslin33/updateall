<?php 
include("../headers/header.php");

//we first need some info, we need to know the username of admin, id of admin
/* $_SESSION["id"] = $id;
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["math_level"] = $mathLevel;
                $_SESSION["english_level"] = $englishLevel;
                $_SESSION["role_id"] = $roleId;
*/

//first we need all the passwords then we can pick one at random
$query = "select password from passwords;";
$result = pg_query($query);
$num = pg_num_rows($result);
$randomNumber = rand(0,$num);
$password = pg_fetch_result($result, $randomNumber, password);

//next we need to know what user we are up to for this admin

/*
$query = "insert into users (username,password,first_name,last_name,role_id,admin_id,teacher_id) values (";

$query = "INSERT INTO users (username,password,role_id,admin_id,teacher_id) VALUES ('$_POST[username]','$_POST[password]',
'$_POST[role_id]','$_POST[admin_id]',
'$_POST[teacher_id]')";

$result = pg_query($query);
*/


?>
</head>

<body>



</body>
</html>

