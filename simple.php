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

//globals

//score
var mScoreNeeded = 0;
var mScore = 0;

//count
var mCountBy = 0;
var mCount = 0;
var mStartNumber = 0;
var mEndNumber = 0;

//ticks
var mTickLength = 0;

//questions
var mQuestion = 0;
var mGuess = 0;
var mAnswer = 0;

// id counter
var mIdCount = 0;

function Game(scoreNeeded, countBy, startNumber, endNumber, tickLength)
{
        //score
        mScoreNeeded = scoreNeeded;

        //count
        mCountBy = countBy;
        mStartNumber = startNumber;
        mEndNumber = endNumber; 

        //ticks
        mTickLength = tickLength;
}

function createPlayer(src,spawnX,spawnY)
{
	//increment uniqueid count	
	mIdCount++;
	
	//create the movable div that will be used to move image around.	
	var div = document.createElement('div');
        div.setAttribute('id','div' + mIdCount);
        div.setAttribute("class","movable");
	div.style.position="absolute";
        document.body.appendChild(div);

	//image to attache to our div "vessel"
        var image = document.createElement("IMG");
        image.id = 'image' + mIdCount;
        image.alt = 'image' + mIdCount;
        image.title = 'image' + mIdCount;   
        div.appendChild(image);
        
	image.src  = src;

        div.mPositionX = 0;
        div.mPositionY = 0;

        div.mVelocityX = 0;
        div.mVelocityY = 0;

        div.mCollidable = true;

	//move it
        div.style.left = spawnX+'px';
        div.style.top  = spawnY+'px';
}

function init()
{
	var game = new Game( <?php echo "$scoreNeeded, $countBy, $startNumber, $endNumber, $tickLength);"; ?>
	createPlayer('smiley.png',300,300);
	createPlayer('1.png',75,75);
	createPlayer('2.png',75,150);
	createPlayer('3.png',300,450);
	createPlayer('4.png',0,150);
	createPlayer('5.png',0,300);
	createPlayer('6.png',150,150);
	createPlayer('7.png',300,0);
	createPlayer('8.png',150,0);
	createPlayer('9.png',450,150);
	createPlayer('10.png',75,300);
		
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
