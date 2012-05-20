<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("headers/header_chooser.php");

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
        mGame.mControlObject = new Shape(mGame,"center","","",50,50,100,100,"","blue","","controlObject");
        mGame.addToShapeArray(mGame.mControlObject);
	
	//create walls
	//left
	mGame.createWall(50,50,"black",-400,300);
	mGame.createWall(50,50,"black",-400,250);
	mGame.createWall(50,50,"black",-400,200);
	mGame.createWall(50,50,"black",-400,150);
	mGame.createWall(50,50,"black",-400,100);
	mGame.createWall(50,50,"black",-400,50);
	mGame.createWall(50,50,"black",-400,0);
	mGame.createWall(50,50,"black",-400,-50);
	mGame.createWall(50,50,"black",-400,-100);
	mGame.createWall(50,50,"black",-400,-150);
	mGame.createWall(50,50,"black",-400,-200);
	mGame.createWall(50,50,"black",-400,-250);
	mGame.createWall(50,50,"black",-400,-300);

  	//right
        mGame.createWall(50,50,"black",400,300);
        mGame.createWall(50,50,"black",400,250);
        mGame.createWall(50,50,"black",400,200);
        mGame.createWall(50,50,"black",400,150);
        mGame.createWall(50,50,"black",400,100);
        mGame.createWall(50,50,"black",400,50);
        mGame.createWall(50,50,"black",400,0);
        mGame.createWall(50,50,"black",400,-50);
        mGame.createWall(50,50,"black",400,-100);
        mGame.createWall(50,50,"black",400,-150);
        mGame.createWall(50,50,"black",400,-200);
        mGame.createWall(50,50,"black",400,-250);
        mGame.createWall(50,50,"black",400,-300);

	//bottom
        mGame.createWall(50,50,"black",-400,300);
        mGame.createWall(50,50,"black",-350,300);
        mGame.createWall(50,50,"black",-300,300);
        mGame.createWall(50,50,"black",-250,300);
        mGame.createWall(50,50,"black",-200,300);
        mGame.createWall(50,50,"black",-150,300);
        mGame.createWall(50,50,"black",-100,300);
        mGame.createWall(50,50,"black",-50,300);
        mGame.createWall(50,50,"black",0,300);
        mGame.createWall(50,50,"black",50,300);
        mGame.createWall(50,50,"black",100,300);
        mGame.createWall(50,50,"black",150,300);
        mGame.createWall(50,50,"black",200,300);
        mGame.createWall(50,50,"black",250,300);
        mGame.createWall(50,50,"black",300,300);
        mGame.createWall(50,50,"black",350,300);
        mGame.createWall(50,50,"black",400,300);

	//top
        mGame.createWall(50,50,"black",-400,-300);
        mGame.createWall(50,50,"black",-350,-300);
        mGame.createWall(50,50,"black",-300,-300);
        mGame.createWall(50,50,"black",-250,-300);
        mGame.createWall(50,50,"black",-200,-300);
        mGame.createWall(50,50,"black",-150,-300);
        mGame.createWall(50,50,"black",-100,-300);
        mGame.createWall(50,50,"black",-50,-300);
        mGame.createWall(50,50,"black",0,-300);
        mGame.createWall(50,50,"black",50,-300);
        mGame.createWall(50,50,"black",100,-300);
        mGame.createWall(50,50,"black",150,-300);
        mGame.createWall(50,50,"black",200,-300);
        mGame.createWall(50,50,"black",250,-300);
        mGame.createWall(50,50,"black",300,-300);
        mGame.createWall(50,50,"black",350,-300);
        mGame.createWall(50,50,"black",400,-300);

	mQuiz = new Quiz(1);
	mGame.mQuiz = mQuiz;

	var questionMath = new Question("Math","chooser.php?table_name=math_games");      
       	mQuiz.mQuestionArray.push(questionMath);
	
	var questionEnglish = new Question("English","chooser.php?table_name=english_games");      
       	mQuiz.mQuestionArray.push(questionEnglish);
               
        count = 0;
        for (i = 0; i < 2; i++)
        {
        	var openPoint = mGame.getOpenPoint2D(-400,400,-300,300,50,4);
                var shape;
                mGame.addToShapeArray(shape = new Shape(mGame,"relative",mQuiz.getSpecificQuestion(count),"",50,50,openPoint.mX,openPoint.mY,i,"yellow","","question"));
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
