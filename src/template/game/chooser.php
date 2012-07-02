<?php 
include("../headers/header.php");


/******* get the level... ***************/
$query = "select LAST(level_id) AS last_level_id from levels_transactions where student_id = ";
$query .= $_SESSION["student_id"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$numberOfRows = pg_num_rows($result);

//$_SESSION["last_level

if ($numberOfRows == 0) {
	//no transaction yet, they are at defacto level zero so we should send them to first level above zero
}
else
{
	//let's find out
}




/******* get the game_id... ***************/
$query = "select game_id, url, id from games_levels where level_id = ";
$query .= "1";
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$numberOfRows = pg_num_rows($result);

echo "<script language=\"javascript\">";
echo "var numberOfRows = $numberOfRows;";
echo "var a = new Array();";
echo "var b = new Array();";

echo "</script>";

$counter = 0;
while ($row = pg_fetch_row($result))
{
        //fill php vars from db
	$game_id = $row[0];
	$b = $row[1];

	//what if right here i did another query to find game name
	$queryGameName = "select game from games where id = ";
	$queryGameName .= $game_id;
	$queryGameName .= ";";  

	//get db result
	$resultGameName = pg_query($conn,$queryGameName) or die('Could not connect: ' . pg_last_error());

	//get numer of rows
	$numberOfRowsGameName = pg_num_rows($resultGameName);

	$a = "sevi";	
	while ($row = pg_fetch_row($resultGameName))
	{	
		$a = $row[0];
	}


	echo "<script language=\"javascript\">";
	
	echo "a[$counter] = \"$a\";";
	echo "b[$counter] = \"$b\";";
	echo "</script>";
	$counter++;
}




//game variables to fill from db
$username = $_SESSION["username"];

?>

<script language="javascript">

var username = "<?php echo $username; ?>";
//var gamelevel = "<?php echo $gameLevel; ?>";

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
		var question = new Question(a[i],b[i]);      
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
