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
        northBoundsABCANDYOU = new Shape(120, 40,  0,  0,"","","","red","boundary");
        northBoundsABCANDYOU.setText('ABCANDYOU');

        northBoundsUser = new Shape     (120, 40,120,  0,"","","","orange","boundary");
        northBoundsUser.setText('User : ' + username);

        northBoundsMathLevel = new Shape(120, 40,240,  0,"","","","yellow","boundary");
        northBoundsMathLevel.setText('Level :');

        northBoundsScore = new Shape    (120, 40,360,  0,"","","","LawnGreen","boundary");
        northBoundsScore.setText('Score : ');

        northBoundsScoreNeeded = new Shape    (120, 40,480,  0,"","","","cyan","boundary");
        northBoundsScoreNeeded.setText('Score Needed : ');

        northBoundsGameName = new Shape (200, 40,600,  0,"","","","#DBCCE6","boundary");
        northBoundsGameName.setText('Game : Subject Chooser');

        eastBounds  = new Shape         ( 10,370,790, 40,"","","","DeepPink","boundary");

        southBoundsQuestion = new Shape (800, 40,  0,410,"","","","DeepPink","boundary");


        westBounds  = new Shape         ( 10,370,  0, 40,"","","","DeepPink","boundary");

	
	//the game
        mGame = new GameChooser("Subject Chooser");

	//control object
        mGame.mControlObject = new Shape(50,50,400,300,mGame,"","","blue","controlObject");
        mGame.addToShapeArray(mGame.mControlObject);
	
	mQuiz = new Quiz(1);
	mGame.mQuiz = mQuiz;

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
