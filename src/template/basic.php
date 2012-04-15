<html>
<head>

<title>ABC AND YOU</title>

<!-- mootools -->
<script type="text/javascript" src="../mootools/mootools-core-1.4.5-full-compat.js"></script>

<?php 
include("../login/check_login.php");
include("../database/db_connect.php");

//db connection
$conn = dbConnect();

//query
$query = "select name, score_needed, count_by, start_number, end_number, tick_length, next_level, number_of_chasers, speed, left_bounds, right_bounds, top_bounds, bottom_bounds, collision_distance from math_games where level = ";
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
$nextLevel = 0;
$numberOfChasers = 0;
$speed = 0;
$leftBounds;
$rightBounds;
$topBounds;
$bottomBounds;
$collisionDistance;

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
	$nextLevel = $row[6];
	$numberOfChasers = $row[7];
	$speed = $row[8];
	$leftBounds = $row[9];
	$rightBounds = $row[10];
	$topBounds = $row[11];
	$bottomBounds = $row[12];
	$collisionDistance = $row[13];
	
	$_SESSION["math_game_next_level"] = $nextLevel;
}

?>

<script language="javascript">

var scoreNeeded = <?php echo $scoreNeeded; ?>;
var countBy = <?php echo $countBy; ?>;
var startNumber = <?php echo $startNumber; ?>;
var endNumber = <?php echo $endNumber; ?>;
var tickLength = <?php echo $tickLength; ?>;
var nextLevel = <?php echo $nextLevel; ?>;
var numberOfChasers = <?php echo $numberOfChasers; ?>;
var speed = <?php echo $speed; ?>;
var leftBounds = <?php echo $leftBounds; ?>;
var rightBounds = <?php echo $rightBounds; ?>;
var topBounds = <?php echo $topBounds; ?>;
var bottomBounds = <?php echo $bottomBounds; ?>;
var collisionDistance = <?php echo $collisionDistance; ?>;

</script>

<script type="text/javascript" src="../game/game.php"></script>
<script type="text/javascript" src="../game/game_dungeon_count.php"></script>
<script type="text/javascript" src="../application/application.php"></script>
<script type="text/javascript" src="../shape/shape.php"></script>
<script type="text/javascript" src="../div/div.php"></script>
<script type="text/javascript" src="../quiz/quiz.php"></script>

</head>
<body>

<div class="demo">

<ul id="sortable">
	<li id="game_name" class="ui-state-default"> <?php echo "$name"; ?> </li>
	<li id="question" class="ui-state-default"> <?php echo $startNumber - 1; ?> </li>
	<li id="feedback" class="ui-state-default"> Have Fun! </li>
	<li id="score" class="ui-state-default"> Score: 0</li>
	<li id="scoreNeeded" class="ui-state-default"> Score Needed: <?php echo "$scoreNeeded"; ?> </li>
</ul>

</div><!-- End demo -->

<script language="javascript">
var mGame;
var mApplication;

window.addEvent('domready', function()
{
	//application to handle time and input
        mApplication = new Application();
        //the game
        mGame = new GameDungeonCount(this, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance);
	
	//call thes "virtual methods"
	mGame.createWorld();
	mGame.resetGame();

        //keys
        document.addEvent("keydown", mApplication.keyDown);
        document.addEvent("keyup", mApplication.keyUp);

        //start updating
        mGame.update();
}
);

window.onresize = function(event)
{
        mApplication.mWindow = window.getSize();
}
</script>

</body>
</html>
