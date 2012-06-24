<?php 
include("../headers/header.php");
include("../links/links.php");

echo "<b><u>My Teachers:<u><b><br>";

$query = "select teachers.user_id, teachers.id from teachers join users on teachers.user_id = users.id where users.school_id = ";
$query .= $_SESSION["school_id"];
$query .= ";";

$result = pg_query($conn,$query);
dbErrorCheck($conn,$result);
$numrows = pg_numrows($result);

?>

<table border="1">
  <tr>
   <th>USER ID</th>
   <th>TEACHER</th>
  </tr>

<?
   // Loop on rows in the result set.

   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["user_id"], "</td>
   <td>", $row["id"], "</td>
  </tr>
  ";
   }
   pg_close($conn);
  ?>
  </table>

</head>
</html>

