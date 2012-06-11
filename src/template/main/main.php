<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../headers/header.php");

//query the db for subjects
$query = "select id, subject from subjects;";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());


//get numer of rows
$numberOfRows = pg_num_rows($result);

echo "<script language=\"javascript\">";
echo "var numberOfRows = $numberOfRows;";
echo "var id = new Array();";
echo "var subject = new Array();";

echo "</script>";

$counter = 0;
while ($row = pg_fetch_array($result)) 
{
        //fill php vars from db
        $id = $row[0];
        $subject = $row[1];

        echo "<script language=\"javascript\">";
        
        echo "id[$counter] = \"$id\";";
        echo "subject[$counter] = \"$subject\";";
        echo "</script>";
        $counter++;
}

//game variables to fill from db
$username = $_SESSION["username"];

?>
</head>

<body>
<p1>WELCOME TO THE MAIN PAGE<p1>
<a href="../choosers/chooser_subject.php">Play Game</a> 
<script language="javascript">
window.addEvent('domready', function()
{

}

);

window.onresize = function(event)
{

}
</script>

</body>
</html>
