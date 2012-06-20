<?php 
include("../headers/header.php");
echo "My Students";

//we first need some info, we need to know the username of admin 
$admin = $_SESSION["username"]; 

//first we need all the passwords then we can pick one at random
$admin = $_SESSION["username"];
$query = "select * from users where admin = '$admin' and role = 'Student';";
$result = pg_query($conn,$query);
dbErrorCheck($conn,$result);
$numrows = pg_numrows($result);

?>

<table border="1">
  <tr>
   <th>Last name</th>
   <th>First name</th>
   <th>Username</th>
  </tr>

<?
   // Loop on rows in the result set.

   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["first_name"], "</td>
   <td>", $row["last_name"], "</td>
   <td>", $row["username"], "</td>
  </tr>
  ";
   }
   pg_close($conn);
  ?>
  </table>

</head>
</html>

