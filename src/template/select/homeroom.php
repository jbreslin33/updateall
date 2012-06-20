<?php 
include("../headers/header.php");
include("../links/links.php");

echo "My Homerooms";

//we first need some info, we need to know the username of admin 
$admin = $_SESSION["username"]; 

//first we need all the passwords then we can pick one at random
$admin = $_SESSION["username"];
$query = "select description, teacher from home_rooms where admin = '$admin';";
$result = pg_query($conn,$query);
dbErrorCheck($conn,$result);
$numrows = pg_numrows($result);

?>

<table border="1">
  <tr>
   <th>Description</th>
   <th>Teacher</th>
  </tr>

<?
   // Loop on rows in the result set.

   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["description"], "</td>
   <td>", $row["teacher"], "</td>
  </tr>
  ";
   }
   pg_close($conn);
  ?>
  </table>

</head>
</html>

