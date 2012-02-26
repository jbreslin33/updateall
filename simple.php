<html>
<head>

<title>Image Mover</title>

<!-- jquery and jqueryui -->
<link type="text/css" href="jquery-ui-1.8.17.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="jquery-1.7.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>

<?php 
include("check_login.php");
include("db_connect.php");

//db connection
$conn = dbConnect();

//query
$query = "select name, score_needed, count_by, start_number, end_number, tick_length from math_games where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$name = "";
$scoreNeeded = 0;
$countBy = 0;
$startNumber = 0;
$endNumber = 0;
$tickLength = 0;

//get numer of rows
$num = pg_num_rows($result);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
        //get row
        $row = pg_fetch_row($result);

        //fill php vars from db
        $name = $row[0];
        $scoreNeeded = $row[1];
        $countBy = $row[2];
        $startNumber = $row[3];
        $endNumber = $row[4];
        $tickLength = $row[5];
}

?>



<script language="javascript">



var x = 5; //Starting Location - left
var y = 5; //Starting Location - top
var interval = 1; //Move 10px every initialization


var idCount = 0;

function game()
{

}

function createPlayer(src)
{
	//increment uniqueid count	
	idCount++;
	
	//create the movable div that will be used to move image around.	
	var div = document.createElement('div');
        div.setAttribute('id','div' + idCount);
        div.setAttribute("class","movable");
	div.style.position="absolute";
        document.body.appendChild(div);

	//image to attache to our div "vessel"
        var image = document.createElement("IMG");
        image.id = 'image' + idCount;
        image.alt = 'image' + idCount;
        image.title = 'image' + idCount;   
        div.appendChild(image);
        
	image.src  = src;

        div.mPositionX = 0;
        div.mPositionY = 0;

        div.mVelocityX = 0;
        div.mVelocityY = 0;

        div.mCollidable = true;

	//move it
        div.style.left = 200+'px';
        div.style.top  = 200+'px';
}

function init()
{
	createPlayer('smiley.png');
}

</script>

</head>

<script type="text/javascript"> 

$(document).ready(function()
{
        init();
}
);

</script>

</body>
</html>
