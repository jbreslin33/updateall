<?php
include("../navigation/select.php");

echo "<b><u>My Teachers:<u><b><br>";

$query = "select teachers.id,  users.username, users.password, users.first_name, users.last_name from teachers join users on teachers.id = users.id where users.school_id = ";
$query .= $_SESSION["school_id"];
$query .= ";";

$result = pg_query($conn,$query);
dbErrorCheck($conn,$result);
$numrows = pg_numrows($result);

?>

<table border="1">
  <tr>
   <th>ID</th>
   <th>USERNAME</th>
   <th>PASSWORD</th>
   <th>FIRST NAME</th>
   <th>LAST NAME</th>
  </tr>

<?
   // Loop on rows in the result set.

   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["id"], "</td>
   <td>", $row["username"], "</td>
   <td>", $row["password"], "</td>
   <td>", $row["first_name"], "</td>
   <td>", $row["last_name"], "</td>
  </tr>
  ";
   }
   pg_close($conn);
  ?>
  </table>

</head>
</html>

