<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../headers/header.php");

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
        mGame = new GameChooser("Subject Chooser");

	//control object
        mGame.mControlObject = new Shape(mGame,"","","",50,50,400,300,"","blue","","controlObject");
        mGame.addToShapeArray(mGame.mControlObject);
	
	mQuiz = new Quiz(1);
	mGame.mQuiz = mQuiz;

	var questionMath = new Question("Math","chooser.php?table_name=math_games");      
       	mQuiz.mQuestionArray.push(questionMath);
	
	var questionEnglish = new Question("English","chooser.php?table_name=english_games");      
       	mQuiz.mQuestionArray.push(questionEnglish);
               
        mGame.addToShapeArray(shape = new Shape(mGame,"relative",questionMath,"",50,50,400,350,"","yellow","","question"));
        mGame.addToShapeArray(shape = new Shape(mGame,"relative",questionEnglish,"",50,50,450,350,"","yellow","","question"));

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
