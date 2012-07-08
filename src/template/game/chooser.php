<?php 
include("../headers/header.php");


/******* join games and games_levels  ***************/
$query = "select games.game, games_levels.url, games.id from games join games_levels on games.id = games_levels.game_id where games_levels.level_id = ";
$query .= $_SESSION["next_level_id"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$numberOfRows = pg_num_rows($result);

echo "<script language=\"javascript\">";
echo "var numberOfRows = $numberOfRows;";
echo "var game_name = new Array();";
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
	$game_id = $row[2];

	echo "<script language=\"javascript\">";
	
	echo "game_name[$counter] = \"$game_name\";";
	echo "url[$counter] = \"$url?game_id=$row[2]\";";
	echo "</script>";
	$counter++;
}




//game variables to fill from db
$username = $_SESSION["username"];

?>

<script language="javascript">

var username = "<?php echo $username; ?>";

</script>

<script type="text/javascript" src="../../math/point2D.php"></script>
<script type="text/javascript" src="../../bounds/bounds.php"></script>
<script type="text/javascript" src="../../game/game.php"></script>
<script type="text/javascript" src="../../game/link_chooser.php"></script>
<script type="text/javascript" src="../../application/application.php"></script>
<script type="text/javascript" src="../../shape/shape.php"></script>
<script type="text/javascript" src="../../div/div.php"></script>
<script type="text/javascript" src="../../question/question.php"></script>
<script type="text/javascript" src="../../quiz/quiz.php"></script>
<script type="text/javascript" src="../../hud/hud.php"></script>

</head>

<body>

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
        northBoundsScoreNeeded.setText('Needed : 1');
	northBoundsGameName.setText('GAME CHOOSER');

	//the game
        mGame = new LinkChooser("Game Chooser");

	//control object
        mGame.mControlObject = new Shape(50,50,400,300,mGame,"","","blue","controlObject");
        mGame.addToShapeArray(mGame.mControlObject);
	
	mQuiz = new Quiz(1);
	mGame.mQuiz = mQuiz;

	var dummyQuestion = new Question("Run over one the games.");
        mQuiz.mQuestionArray.push(dummyQuestion);

	//create quiz items
 	for (i = 0; i < numberOfRows; i++)
        {
		var question = new Question(game_name[i],url[i]);      
                mQuiz.mQuestionArray.push(question);
        }
                
        count = 1;
        for (i = 1; i < numberOfRows + 1; i++ )
        {
                var shape;
		x = i * 50 + 400;
                mGame.addToShapeArray(shape = new Shape(50,50,x,350,mGame,mQuiz.getSpecificQuestion(count),"","yellow","question"));
                //shape.showQuestion(false);
               	count++;
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
