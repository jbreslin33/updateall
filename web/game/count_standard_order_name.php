
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
var scoreNeeded = Math.floor(Math.random()*10);

</script>

<script type="text/javascript" src="/src/math/point2D.php"></script>
<script type="text/javascript" src="/src/bounds/bounds.php"></script>
<script type="text/javascript" src="/src/game/game.php"></script>
<script type="text/javascript" src="/src/application/application.php"></script>
<script type="text/javascript" src="/src/animation/animation.php"></script>
<script type="text/javascript" src="/src/animation/animation_advanced.php"></script>
<script type="text/javascript" src="/src/shape/shape.php"></script>
<script type="text/javascript" src="/src/shape/shape_player.php"></script>
<script type="text/javascript" src="/src/shape/shape_door.php"></script>
<script type="text/javascript" src="/src/shape/shape_dropbox.php"></script>
<script type="text/javascript" src="/src/shape/shape_dropbox_count.php"></script>
<script type="text/javascript" src="/src/shape/shape_ai.php"></script>
<script type="text/javascript" src="/src/div/div.php"></script>
<script type="text/javascript" src="/src/question/question.php"></script>
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

	//QUESTIONS FOR QUIZ
        mQuiz.mQuestionArray.push(new Question('','One'));
        mQuiz.mQuestionArray.push(new Question('','Two'));
        mQuiz.mQuestionArray.push(new Question('','Three'));
        mQuiz.mQuestionArray.push(new Question('','Four'));
        mQuiz.mQuestionArray.push(new Question('','Five'));
        mQuiz.mQuestionArray.push(new Question('','Six'));
        mQuiz.mQuestionArray.push(new Question('','Seven'));
        mQuiz.mQuestionArray.push(new Question('','Eight'));
        mQuiz.mQuestionArray.push(new Question('','Nine'));
        mQuiz.mQuestionArray.push(new Question('','Ten'));
        mQuiz.mQuestionArray.push(new Question('','Eleven'));
        mQuiz.mQuestionArray.push(new Question('','Twelve'));
        mQuiz.mQuestionArray.push(new Question('','Thirteen'));
        mQuiz.mQuestionArray.push(new Question('','Fourteen'));
        mQuiz.mQuestionArray.push(new Question('','Fifteen'));
        mQuiz.mQuestionArray.push(new Question('','Sixteen'));
        mQuiz.mQuestionArray.push(new Question('','Seventeen'));
        mQuiz.mQuestionArray.push(new Question('','Eighteen'));
        mQuiz.mQuestionArray.push(new Question('','Nineteen'));
        mQuiz.mQuestionArray.push(new Question('','Twenty'));

       	mQuiz.mQuestionArray.push(new Question('', 'Open door with key.'));      

	//CONTROL OBJECT
        mGame.mControlObject = new Player(50,50,400,300,mGame,mQuiz.getSpecificQuestion(0),"/images/characters/wizard.png","","controlObject");
	mGame.mControlObject.createMountPoint(0,-5,-41);


        //set animation instance
        mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

 	mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');

 	mGame.addToShapeArray(mGame.mControlObject);
        mGame.mControlObject.showQuestionObject(false);

        //question for key
        var keyQuestion = new Question('Pick up key.',"key");
        mQuiz.mQuestionArray.push(keyQuestion);

        //KEY
        openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
        var key = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,keyQuestion,"/images/key/key_dungeon.gif","","key");
        key.setVisibility(false);
        key.mShowOnlyOnQuizComplete = true;
        key.mMountable = true;
        key.setHideOnQuestionSolved(false);
        mGame.addToShapeArray(key);

        //question for door
        var doorQuestion = new Question('Open door with key.',"door");
        mQuiz.mQuestionArray.push(doorQuestion);

        //DOOR
        var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
        var door = new ShapeDoor(50,50,openPoint.mX,openPoint.mY,mGame,doorQuestion,"/images/doors/door_closed.png","","door","/images/doors/door_open.png");
        door.mUrl = '/src/database/goto_next_level.php';
        door.mOpenOnQuestionSolved = true;
        mGame.addToShapeArray(door);

	//QUESTION SHAPES (GOLD COINS)
        for (i = 0; i < scoreNeeded; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape;
               	//mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(i),"/images/treasure/gold_coin_head.png","","pickup"));
               	mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,"","/images/treasure/gold_coin_head.png","","pickup"));
                shape.createMountPoint(0,-5,-41);
                shape.showQuestion(false);
		shape.mMountable = true;
		shape.setHideOnQuestionSolved(false);

		//numberMount to go on top let's make it small and draw it on top 
                var numberMountee = new Shape(1,1,100,100,mGame,mQuiz.getSpecificQuestion(i),"","orange","numberMountee");       
                mGame.addToShapeArray(numberMountee); 
                numberMountee.showQuestion(false);
                
		//do the mount  
		shape.mount(numberMountee,0);

		numberMountee.setBackgroundColor("transparent");
        }

	//TREASURE CHESTS TO COUNT
	for (i = 0; i < scoreNeeded; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape = new ShapeDropBoxCount(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(0),"/images/treasure/chest.png","","dropbox_question");
                shape.createMountPoint(0,-5,-41);
		shape.setHideOnQuestionSolved(false);
		mGame.addToShapeArray(shape);
        }

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
