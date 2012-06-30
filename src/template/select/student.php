<?php 
include("../headers/header.php");
include("../links/links.php");

echo "<b><u>My Students:<u><b><br>";

$query = "select students.user_id, students.id, users.username, users.password, users.first_name, users.last_name from students join users on students.user_id = users.id where users.school_id = ";
$query .= $_SESSION["school_id"];
$query .= ";";

$result = pg_query($conn,$query);
dbErrorCheck($conn,$result);
$numrows = pg_numrows($result);

?>

<table border="1">
  <tr>
   <th>USER ID</th>
   <th>STUDENT ID</th>
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
    echo " <td>", $row["user_id"], "</td>
   <td>", $row["id"], "</td>
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

