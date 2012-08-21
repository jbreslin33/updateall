
<html>
<head>

<title>ABC AND YOU</title>

<!-- mootools -->
<script type="text/javascript" src="/src/mootools/mootools-core-1.4.5-full-compat.js"></script>

<?php

include(getenv("DOCUMENT_ROOT") . "/web/login/check_login.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/db_connect.php");

//game variables to fill from db
$username = $_SESSION["username"];
$next_level = $_SESSION["next_level"];

?>

<script language="javascript">

var username = "<?php echo $username; ?>";
var next_level = "<?php echo $next_level; ?>";
var scoreNeeded = 10;
var kidsRedShirt = 6;
var kidsGreenShirt = 6;

</script>

<script type="text/javascript" src="/src/math/point2D.php"></script>
<script type="text/javascript" src="/src/bounds/bounds.php"></script>
<script type="text/javascript" src="/src/game/game.php"></script>
<script type="text/javascript" src="/src/application/application.php"></script>
<script type="text/javascript" src="/src/animation/animation.php"></script>
<script type="text/javascript" src="/src/animation/animation_advanced.php"></script>
<script type="text/javascript" src="/src/shape/shape.php"></script>
<script type="text/javascript" src="/src/shape/shape_player.php"></script>
<script type="text/javascript" src="/src/div/div.php"></script>
<script type="text/javascript" src="/src/question/question.php"></script>
<script type="text/javascript" src="/src/question/question_compare.php"></script>
<script type="text/javascript" src="/src/quiz/quiz.php"></script>
<script type="text/javascript" src="/src/hud/hud.php"></script>

</head>

<body bgcolor="grey">

<script language="javascript">
var mGame;
var mApplication;

window.addEvent('domready', function()
{
	//APPLICATION
        mApplication = new Application();
 
        //KEYS
        document.addEvent("keydown", mApplication.keyDown);
        document.addEvent("keyup", mApplication.keyUp);
	
	//BOUNDS AND HUD COMBO
        mBounds = new Bounds(60,735,380,35);

       	mHud = new Hud();
        mHud.mScoreNeeded.setText('<font size="2"> Needed : ' + scoreNeeded + '</font>');
	mHud.mGameName.setText('<font size="2">DUNGEON</font>');	
	
	//GAME
        mGame = new Game("hardcode");

	//QUIZ 
	mQuiz = new Quiz(scoreNeeded);
	mGame.mQuiz = mQuiz;

       	//QUESIONS	
//	mQuiz.mQuestionArray.push(new QuestionCompare('The red shirt kids are greater, less than or equal to the green shirt kids?', 'greater',3,5));      

	for (i = 0; i < scoreNeeded; i++)
	{
		var a = Math.floor(Math.random()*6);
		var b = Math.floor(Math.random()*6);
		mQuiz.mQuestionArray.push(new QuestionCompare('The red shirt kids are greater, less than or equal to the green shirt kids?', 'greater',a,b));      
	}
	
	//CONTROL OBJECT
        mGame.mControlObject = new Player(50,50,400,300,mGame,'',"/images/characters/wizard.png","","controlObject");

        //set animation instance
        mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

 	mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');

 	mGame.addToShapeArray(mGame.mControlObject);
        mGame.mControlObject.showQuestionObject(false);

	//KIDS RED SHIRT
        for (i = 0; i < kidsRedShirt; i++)
        {
                var shape;
               	mGame.addToShapeArray(shape = new Shape(50,50,75,50 + (i * 50),mGame,'',"/images/characters/kid_red_shirt/kid_red_shirt.png","","kid"));
                shape.showQuestion(false);
        }

	//KIDS GREEN SHIRT
        for (i = 0; i < kidsGreenShirt; i++)
        {
                var shape;
               	mGame.addToShapeArray(shape = new Shape(50,50,650,50 + (i * 50),mGame,'',"/images/characters/kid_green_shirt/kid_green_shirt.png","","kid"));
                shape.showQuestion(false);
        }

	//SYMBOLS
        var greaterThan = mGame.addToShapeArray(shape = new Shape(50,50,300,200,mGame,new Question('','greater_than'),"/images/symbols/greater_than.png","","greater_than"));
        var lessThan    = mGame.addToShapeArray(shape = new Shape(50,50,400,200,mGame,new Question('','less_than'),"/images/symbols/less_than.png","","less_than"));
        var equalTo     = mGame.addToShapeArray(shape = new Shape(50,50,500,200,mGame,new Question('','equal_to'),"/images/symbols/equal.png","","equal_to"));

	//RESET GAME TO START
	mGame.resetGame();

        //START UPDATING
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
