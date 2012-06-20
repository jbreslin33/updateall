<?php 
include("../headers/header.php");
include("../links/links.php");

echo "My Students";

//we first need some info, we need to know the username of admin 
$admin = $_SESSION["username"]; 

//first we need all the passwords then we can pick one at random
$admin = $_SESSION["username"];
$query = "select username, password, last_name, first_name, teacher, math_level, english_level from users where admin = '$admin' and role = 'Student';";
$result = pg_query($conn,$query);
dbErrorCheck($conn,$result);
$numrows = pg_numrows($result);

?>

<table border="1">
  <tr>
   <th>Username</th>
   <th>Password</th>
   <th>Last name</th>
   <th>First name</th>
   <th>Teacher</th>
   <th>Math Level</th>
   <th>English Level</th>
  </tr>

<?
   // Loop on rows in the result set.

   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["username"], "</td>
   <td>", $row["password"], "</td>
   <td>", $row["last_name"], "</td>
   <td>", $row["first_name"], "</td>
   <td>", $row["teacher"], "</td>
   <td>", $row["math_level"], "</td>
   <td>", $row["english_level"], "</td>
  </tr>
  ";
   }
   pg_close($conn);
  ?>
  </table>

</head>
</html>

