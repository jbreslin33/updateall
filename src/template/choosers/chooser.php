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

?>

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
	
	//the game
        mGame = new GameChooser("Game Chooser");

	//control object
        mGame.mControlObject = new Shape(mGame,"","","",50,50,400,300,"","blue","","controlObject");
        mGame.addToShapeArray(mGame.mControlObject);
	
	mQuiz = new Quiz(1);
	mGame.mQuiz = mQuiz;

	//create quiz items
 	for (i = 0; i < numberOfRows; i++)
        {
		var question = new Question(gameName[i],url[i]);      
                mQuiz.mQuestionArray.push(question);
        }
                
        count = 0;
        for (i = 0; i < numberOfRows; i++ )
        {
                var shape;
		x = i * 50 + 400;
                mGame.addToShapeArray(shape = new Shape(mGame,"",mQuiz.getSpecificQuestion(count),"",50,50,x,350,"","yellow","","question"));
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
