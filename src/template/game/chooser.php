<?php 
include("../headers/header.php");

$_SESSION["subject_id"] = $_GET["subject"];

query = "select domains.id from domains join subjects on domains.subject_id = subjects.id where subjects.id = ";
$query .= $_SESSION["subject_id"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$numberOfRows = pg_num_rows($result);

if ($numberOfRows > 0)
{
	$_SESSION["domain_id"] = pg_Result($result, 0, 'domains.id');
}
else
{
	$_SESSION["domain_id"] = 0;
}

query = "select clusters.id from clusters join domains on clusters.domain_id = domains.id where domains.id = ";
$query .= $_SESSION["domain_id"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$numberOfRows = pg_num_rows($result);

if ($numberOfRows > 0)
{
        $_SESSION["cluster_id"] = pg_Result($result, 0, 'clusters.id');
}
else
{
        $_SESSION["cluster_id"] = 0;
}



query = "select standards.id from standards join clusters on standards.cluster_id = clusters.id where clusters.id = ";
$query .= $_SESSION["cluster_id"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$numberOfRows = pg_num_rows($result);

if ($numberOfRows > 0)
{
        $_SESSION["standard_id"] = pg_Result($result, 0, 'standards.id');
}
else
{
        $_SESSION["standard_id"] = 0;
}


query = "select levels.id from levels join standards on levels.standard_id = standards.id where standards.id = ";
$query .= $_SESSION["standard_id"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows
$numberOfRows = pg_num_rows($result);

if ($numberOfRows > 0)
{
        $_SESSION["level_id"] = pg_Result($result, 0, 'levels.id');
}
else
{
        $_SESSION["level_id"] = 0;
}












echo "<script language=\"javascript\">";
echo "var numberOfRows = $numberOfRows;";
echo "var id = new Array();";
echo "var domain = new Array();";

echo "</script>";

$counter = 0;
while ($row = pg_fetch_array($result)) 
{
        //fill php vars from db
        $id = $row[0];
        $domain = $row[1];

	echo "<script language=\"javascript\">";
	
	echo "id[$counter] = \"$id\";";
	echo "domain[$counter] = \"$domain\";";
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
		var question = new Question(id[i],domain[i]);      
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
