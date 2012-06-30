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

 /******************* BOUNDARY WALLS AND HUD COMBO ***********/
        var y = 35;
        northBoundsABCANDYOU = new Shape(120, y,  0,  0,"","","","red","boundary");
        northBoundsABCANDYOU.setText('ABCANDYOU');

        northBoundsUser = new Shape     (120, y,120,  0,"","","","orange","boundary");
        northBoundsUser.setText('User : ' + username);

        northBoundsMathLevel = new Shape(120, y,240,  0,"","","","yellow","boundary");
        northBoundsMathLevel.setText('Level : ');

        northBoundsScore = new Shape    (120, y,360,  0,"","","","LawnGreen","boundary");
        northBoundsScore.setText('Score : ');

        northBoundsScoreNeeded = new Shape    (120, y,480,  0,"","","","cyan","boundary");
        northBoundsScoreNeeded.setText('Score Needed : ');

        northBoundsGameName = new Shape (170, y,600,  0,"","","","#DBCCE6","boundary");
        northBoundsGameName.setText('Choose Subject');

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
                var question = new Question(subject[i],id[i]);      
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
