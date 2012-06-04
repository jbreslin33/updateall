<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../headers/header.php");

//query the game table, eventually maybe there will be more than one result here which would be a choice of game for that level. that day hath arrived
$tableName = $_GET['table_name'];
$gameLevel = 0;

if ($tableName == "math_games")
{
	$gameLevel = $_SESSION["math_level"];
}
if ($tableName == "english_games")
{
	$gameLevel = $_SESSION["english_level"];
}



$query = "select name, url from ";
$query .= $tableName; 
$query .= " where level = ";
$query .= $gameLevel;
$query .= ";";
echo $query;
//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$numberOfRows = pg_num_rows($result);

echo "<script language=\"javascript\">";
echo "var numberOfRows = $numberOfRows;";
echo "var gameName = new Array();";
echo "var url = new Array();";

echo "</script>";

$counter = 0;
while ($row = pg_fetch_array($result)) 
{
        //fill php vars from db
        $gameName = $row[0];
        $url = $row[1];

	echo "<script language=\"javascript\">";
	
	echo "gameName[$counter] = \"$gameName\";";
	echo "url[$counter] = \"$url\";";
	echo "</script>";
	$counter++;
}

//game variables to fill from db
$username = $_SESSION["username"];

?>

<script language="javascript">

var username = "<?php echo $username; ?>";
var gamelevel = "<?php echo $gameLevel; ?>";

</script>

<script type="text/javascript" src="../../math/point2D.php"></script>
<script type="text/javascript" src="../../game/game.php"></script>
<script type="text/javascript" src="../../game/game_chooser.php"></script>
<script type="text/javascript" src="../../application/application.php"></script>
<script type="text/javascript" src="../../shape/shape.php"></script>
<script type="text/javascript" src="../../div/div.php"></script>
<script type="text/javascript" src="../../question/question.php"></script>
<script type="text/javascript" src="../../quiz/quiz.php"></script>

</head>

<body>

<script language="javascript">
var mGame;
var mApplication;

window.addEvent('domready', function()
{
	//application to handle time and input
        mApplication = new Application();
        
        //keys
        document.addEvent("keydown", mApplication.keyDown);
        document.addEvent("keyup", mApplication.keyUp);

 	/******************* BOUNDARY WALLS AND HUD COMBO ***********/
        var y = 35;
        northBoundsABCANDYOU = new Shape(120, y,  0,  0,"","","","red","boundary");
        northBoundsABCANDYOU.setText('ABCANDYOU');

        northBoundsUser = new Shape     (120, y,120,  0,"","","","orange","boundary");
        northBoundsUser.setText('User : ' + username);

        northBoundsMathLevel = new Shape(120, y,240,  0,"","","","yellow","boundary");
        northBoundsMathLevel.setText('Math Level : ' + gamelevel);

        northBoundsScore = new Shape    (120, y,360,  0,"","","","LawnGreen","boundary");
        northBoundsScore.setText('Score : ');

        northBoundsScoreNeeded = new Shape    (120, y,480,  0,"","","","cyan","boundary");
        northBoundsScoreNeeded.setText('Score Needed : ');

        northBoundsGameName = new Shape (170, y,600,  0,"","","","#DBCCE6","boundary");
        northBoundsGameName.setText('Game Chooser');

        eastBounds  = new Shape         ( 10, 50,760, 35,"","","","#F8CDF8","boundary");
        eastBounds  = new Shape         ( 10, 50,760, 85,"","","","#F6C0F6","boundary");
        eastBounds  = new Shape         ( 10, 50,760,135,"","","","#F5B4F5","boundary");
        eastBounds  = new Shape         ( 10, 50,760,185,"","","","#F6C0F6","boundary");
        eastBounds  = new Shape         ( 10, 50,760,235,"","","","#F5B4F5","boundary");
        eastBounds  = new Shape         ( 10, 50,760,285,"","","","#F3A8F3","boundary");
        eastBounds  = new Shape         ( 10, 50,760,335,"","","","#F19BF1","boundary");
        eastBounds  = new Shape         ( 10, 20,760,385,"","","","#F08EF0","boundary");

        southBoundsQuestion = new Shape (770, y,  0,405,"","","","violet","boundary");

        westBounds  = new Shape         ( 10, 50,  0, 35,"","","","#F8CDF8","boundary");
        westBounds  = new Shape         ( 10, 50,  0, 85,"","","","#F6C0F6","boundary");
        westBounds  = new Shape         ( 10, 50,  0,135,"","","","#F5B4F5","boundary");
        westBounds  = new Shape         ( 10, 50,  0,185,"","","","#F6C0F6","boundary");
        westBounds  = new Shape         ( 10, 50,  0,235,"","","","#F5B4F5","boundary");
        westBounds  = new Shape         ( 10, 50,  0,285,"","","","#F3A8F3","boundary");
        westBounds  = new Shape         ( 10, 50,  0,335,"","","","#F19BF1","boundary");
        westBounds  = new Shape         ( 10, 20,  0,385,"","","","#F08EF0","boundary");

	//the game
        mGame = new GameChooser("Game Chooser");

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
		var question = new Question(gameName[i],url[i]);      
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
