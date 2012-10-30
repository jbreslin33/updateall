<html>
<head>

<title>ABC AND YOU</title>

<!-- mootools -->
<script type="text/javascript" src="/src/mootools/mootools-core-1.4.5-full-compat.js"></script>

<?php
include(getenv("DOCUMENT_ROOT") . "/web/login/check_login.php"); 
include(getenv("DOCUMENT_ROOT") . "/src/database/db_connect.php"); 

//db connection
$conn = dbConnect();


/******* join games and games_levels  ***************/
$query = "select games.game, games_levels.url, games.picture_open, games.picture_closed, games.id from games join games_levels on games.id = games_levels.game_id where games_levels.level_id = ";
$query .= $_SESSION["next_level_id"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$numberOfRows = pg_num_rows($result);

echo "<script language=\"javascript\">";
echo "var numberOfRows = $numberOfRows;";
echo "var game_name = new Array();";
echo "var picture_open = new Array();";
echo "var picture_closed = new Array();";
echo "var url = new Array();";

$next_level = $_SESSION["next_level"];
echo "var next_level = $next_level;";

echo "</script>";

$counter = 0;
while ($row = pg_fetch_row($result))
{
        //fill php vars from db
	$game_name = $row[0];
	$url = $row[1];
	$picture_open = $row[2];
	$picture_closed = $row[3];
	$game_id = $row[4];

	echo "<script language=\"javascript\">";
	
	echo "game_name[$counter] = \"$game_name\";";
	echo "url[$counter] = \"$url?game_id=$game_id\";";
	echo "picture_open[$counter] = \"$picture_open\";";
	echo "picture_closed[$counter] = \"$picture_closed\";";
	echo "</script>";
	$counter++;
}

//game variables to fill from db
$username = $_SESSION["username"];

?>

<script language="javascript">

var username = "<?php echo $username; ?>";

</script>

<script type="text/javascript" src="/src/math/point2D.php"></script>
<script type="text/javascript" src="/src/bounds/bounds.php"></script>
<script type="text/javascript" src="/src/game/game.php"></script>
<script type="text/javascript" src="/src/application/application.php"></script>
<script type="text/javascript" src="/src/shape/shape.php"></script>
<script type="text/javascript" src="/src/shape/shape_door.php"></script>
<script type="text/javascript" src="/src/animation/animation.php"></script>
<script type="text/javascript" src="/src/animation/animation_advanced.php"></script>
<script type="text/javascript" src="/src/div/div.php"></script>
<script type="text/javascript" src="/src/question/question.php"></script>
<script type="text/javascript" src="/src/quiz/quiz.php"></script>
<script type="text/javascript" src="/src/hud/hud.php"></script>

</head>

<body bgcolor="grey">

<script language="javascript">
var mGame;
var mApplication;

window.addEvent('domready', function()
{
	//application to handle time and input
        mApplication = new Application();

	//bounds
        mBounds = new Bounds(60,735,380,35);
        
        //keys
        document.addEvent("keydown", mApplication.keyDown);
        document.addEvent("keyup", mApplication.keyUp);

	mHud = new Hud();
        mHud.mScoreNeeded.setText('<font size="2"> Needed : 1 </font>');
	mHud.mGameName.setText('<font size="2">GAME CHOOSER</font>');

	//the game
        mGame = new Game("Game Chooser");

	//control object
        mGame.mControlObject = new Shape(50,50,400,300,mGame,'',"/images/characters/wizard.png","","controlObject");

 	//set animation instance
        mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

	mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');
        
	mGame.addToShapeArray(mGame.mControlObject);
	
        for (i = 1; i < numberOfRows + 1; i++ )
        {
                var shape;
		x = i * 50 + 400;
                shape = new ShapeDoor(50,50,x,350,mGame,'',picture_closed[i-1],"","door",picture_open[i-1]);
		shape.setOpenDoor(true);
		shape.mUrl = url[i-1]; 
		mApplication.log('mUrl:' + shape.mUrl);
                mGame.addToShapeArray(shape);
        }

	//end create quiz items

	mGame.resetGame();

        //start updating
        var t=setInterval("mGame.update()",32)
}

);

window.onresize = function(event)
{
        mApplication.mWindow = window.getSize();
}
</script>

</body>
</html>
