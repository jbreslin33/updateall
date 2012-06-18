<?php 
include("../headers/header.php");

//we first need some info, we need to know the username of admin, id of admin

$query = "insert into users (username,password,first_name,last_name,role_id,admin_id,teacher_id) values (";

$query = "INSERT INTO users (username,password,first_name,last_name,role_id,admin_id,teacher_id) VALUES ('$_POST[username]','$_POST[password]',
'$_POST[first_name]','$_POST[last_name]','$_POST[role_id]','$_POST[admin_id]',
'$_POST[teacher_id]')";

$result = pg_query($query);

?>
</head>

<body>



</body>
</html>

