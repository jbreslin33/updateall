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

	//the game
        mGame = new LinkChooser("Subject Chooser");

	//control object
        mGame.mControlObject = new Shape(50,50,400,300,mGame,"","","blue","controlObject");
        mGame.addToShapeArray(mGame.mControlObject);
	
	mQuiz = new Quiz(1);
	mGame.mQuiz = mQuiz;

	var dummyQuestion = new Question("Run over one the subjects.");
       	mQuiz.mQuestionArray.push(dummyQuestion);

	//create quiz items
        for (i = 0; i < numberOfRows; i++)
        {
                var question = new Question(subject[i],'../game/chooser.php?subject=' + id[i]);      
                mQuiz.mQuestionArray.push(question);
        }
                
        count = 1;
        for (i = 1; i < numberOfRows + 1; i++ )
        {
                var shape;
                x = i * 50 + 400;
                mGame.addToShapeArray(shape = new Shape(50,50,x,350,mGame,mQuiz.getSpecificQuestion(count),"","yellow","question"));
                count++;
        }

	mGame.resetGame();

        //start updating
   	var t=setInterval("mGame.update()",10)
}

);

window.onresize = function(event)
{
        mApplication.mWindow = window.getSize();
}
</script>

</body>
</html>
