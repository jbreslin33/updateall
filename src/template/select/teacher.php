<?php 
include("../headers/header.php");
include("../links/links.php");

echo "My Students, well not really it's everybody in the whole db's students...for now until we do a join";

//$query = "select id, math_level, english_level from students;";
$query = "select * from students join users on students.user_id = users.id where users.school_id = ";
$query .= $_SESSION["school_id"];
$query .= ";";

//$query .= $_SESSION["school_id"];
//$query .= ";";
$result = pg_query($conn,$query);
dbErrorCheck($conn,$result);
$numrows = pg_numrows($result);

?>

<table border="1">
  <tr>
   <th>id</th>
   <th>Math Level</th>
   <th>English Level</th>
  </tr>

<?
   // Loop on rows in the result set.

   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["id"], "</td>
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

