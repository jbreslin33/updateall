<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../headers/header.php");

//game variables to fill from db
$username = $_SESSION["username"];

?>

<script language="javascript">

var username = "<?php echo $username; ?>";

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
        mGame = new GameChooser("Subject Chooser");

	//control object
        mGame.mControlObject = new Shape(50,50,400,300,mGame,"","","blue","controlObject");
        mGame.addToShapeArray(mGame.mControlObject);
	
	mQuiz = new Quiz(1);
	mGame.mQuiz = mQuiz;

	var dummyQuestion = new Question("Run over one the subjects.");
       	mQuiz.mQuestionArray.push(dummyQuestion);

	var questionMath = new Question("Math","chooser.php?table_name=math_games");      
       	mQuiz.mQuestionArray.push(questionMath);
	
	var questionEnglish = new Question("English","chooser.php?table_name=english_games");      
       	mQuiz.mQuestionArray.push(questionEnglish);
               
        mGame.addToShapeArray(shape = new Shape(50,50,400,350,mGame,questionMath,"","yellow","question"));
        mGame.addToShapeArray(shape = new Shape(50,50,450,350,mGame,questionEnglish,"","yellow","question"));

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
