<!--
Count to tell the number of objects. 	
4.	 Understand the relationship between numbers and quantities; connect
counting to cardinality.
a.	 When counting objects, say the number names in the standard
order, pairing each object with one and only one number name
and each number name with one and only one object.

: to do this without involving number pad yet?
or do we use number pad
if we use number pad we can just lineup coins with no question and no answer. 
then you set urself to one. and hit one of them. that coin becomes 1. so your question array is in order
but the coins get the questions as you collide.

we could also do a hybrid where there is a number pad on the screen at bottom that you can collide with to set your player answer.


we need to be able to pick up numbers and drop them off... 
using current question system. all "question" shapes would start with question 0 and answer 1.
then when that is answered correctly then all question shapes are given question 1,2. etc. 
-->

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

</script>


<script type="text/javascript" src="/src/math/point2D.php"></script>
<script type="text/javascript" src="/src/bounds/bounds.php"></script>
<script type="text/javascript" src="/src/game/game.php"></script>
<script type="text/javascript" src="/src/game/dungeon.php"></script>
<script type="text/javascript" src="/src/game/dungeon_how_many.php"></script>
<script type="text/javascript" src="/src/application/application.php"></script>
<script type="text/javascript" src="/src/animation/animation.php"></script>
<script type="text/javascript" src="/src/animation/animation_advanced.php"></script>
<script type="text/javascript" src="/src/shape/shape.php"></script>
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
        mGame = new DungeonHowMany("hardcode");

	//QUIZ 
	mQuiz = new Quiz(scoreNeeded);
	mGame.mQuiz = mQuiz;

	//QUESTIONS FOR QUIZ
 	//Math.floor(Math.random()*ySize)



       	mQuiz.mQuestionArray.push(new Question('How many Frozen Red Monsters?', '' + Math.floor(Math.random()*20)));      
       	mQuiz.mQuestionArray.push(new Question('How many Frozen Red Monsters?', '' + Math.floor(Math.random()*20)));      
       	mQuiz.mQuestionArray.push(new Question('How many Frozen Red Monsters?', '' + Math.floor(Math.random()*20)));      
       	mQuiz.mQuestionArray.push(new Question('How many Frozen Red Monsters?', '' + Math.floor(Math.random()*20)));      
       	mQuiz.mQuestionArray.push(new Question('How many Frozen Red Monsters?', '' + Math.floor(Math.random()*20)));      
       	mQuiz.mQuestionArray.push(new Question('How many Frozen Red Monsters?', '' + Math.floor(Math.random()*20)));      
       	mQuiz.mQuestionArray.push(new Question('How many Frozen Red Monsters?', '' + Math.floor(Math.random()*20)));      
       	mQuiz.mQuestionArray.push(new Question('How many Frozen Red Monsters?', '' + Math.floor(Math.random()*20)));      
       	mQuiz.mQuestionArray.push(new Question('How many Frozen Red Monsters?', '' + Math.floor(Math.random()*20)));      
       	mQuiz.mQuestionArray.push(new Question('How many Frozen Red Monsters?', '' + Math.floor(Math.random()*20)));      
       	
	mQuiz.mQuestionArray.push(new Question('Door is Open!', '0'));      

	//CONTROL OBJECT
        mGame.mControlObject = new Shape(50,50,400,300,mGame,mQuiz.getSpecificQuestion(0),"/images/characters/wizard.png","","controlObject");

        //set animation instance
        mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

        mGame.mControlObject.mAnimation.mAnimationArray[0] = new Array();
        mGame.mControlObject.mAnimation.mAnimationArray[1] = new Array();
        mGame.mControlObject.mAnimation.mAnimationArray[2] = new Array();
        mGame.mControlObject.mAnimation.mAnimationArray[3] = new Array();
        mGame.mControlObject.mAnimation.mAnimationArray[4] = new Array();
        mGame.mControlObject.mAnimation.mAnimationArray[5] = new Array();
        mGame.mControlObject.mAnimation.mAnimationArray[6] = new Array();
        mGame.mControlObject.mAnimation.mAnimationArray[7] = new Array();
        mGame.mControlObject.mAnimation.mAnimationArray[8] = new Array();

        mGame.mControlObject.mAnimation.mAnimationArray[0][0] = "/images/characters/wizard_north.png";
        mGame.mControlObject.mAnimation.mAnimationArray[1][0] = "/images/characters/wizard_north.png";
//      mGame.mControlObject.mAnimation.mAnimationArray[1][1] = "/images/characters/wizard_south.png";
        mGame.mControlObject.mAnimation.mAnimationArray[2][0] = "/images/characters/wizard_north_east.png"; mGame.mControlObject.mAnimation.mAnimationArray[3][0] = "/images/characters/wizard_east.png";
        mGame.mControlObject.mAnimation.mAnimationArray[4][0] = "/images/characters/wizard_south_east.png";
        mGame.mControlObject.mAnimation.mAnimationArray[5][0] = "/images/characters/wizard_south.png";
        mGame.mControlObject.mAnimation.mAnimationArray[6][0] = "/images/characters/wizard_south_west.png";
        mGame.mControlObject.mAnimation.mAnimationArray[7][0] = "/images/characters/wizard_west.png";
        mGame.mControlObject.mAnimation.mAnimationArray[8][0] = "/images/characters/wizard_north_west.png";

 	mGame.addToShapeArray(mGame.mControlObject);
        mGame.mControlObject.showQuestionObject(false);

        //numberMount to go on top let's make it small and draw it on top
        var numberMountee = new Shape(100,50,300,300,mGame,mQuiz.getSpecificQuestion(0),"","orange","numberMountee");
        mGame.addToShapeArray(numberMountee);

        //do the mount
        //ie is showing this too high
        if (navigator.appName == "Microsoft Internet Explorer" || navigator.appName == "Opera")
        {
                mGame.mControlObject.mount(numberMountee,-5,-41);
        }
        else
        {
                mGame.mControlObject.mount(numberMountee,-5,-58);
        }

        numberMountee.setBackgroundColor("transparent");

	//DOOR
       	var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
	var door = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,new Question("DOOR","/src/database/goto_next_level.php"),"/images/doors/door_closed.png","","wall");
	mGame.addToShapeArray(door);
               
	//QUESTION SHAPES 
        for (i = 0; i < scoreNeeded; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape;
               	mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(i),"/images/treasure/gold_coin_head.png","","question"));
                shape.showQuestion(false);

		//numberMount to go on top let's make it small and draw it on top 
                var numberMountee = new Shape(1,1,100,100,mGame,mQuiz.getSpecificQuestion(i),"","orange","numberMountee");       
                mGame.addToShapeArray(numberMountee); 
                numberMountee.showQuestion(false);
                
		//do the mount  
		//ie is showing this too high	
		if (navigator.appName == "Microsoft Internet Explorer" || navigator.appName == "Opera")
		{
			shape.mount(numberMountee,-5,-41);
		}	
		else
		{
			shape.mount(numberMountee,-5,-58);
              	} 

		numberMountee.setBackgroundColor("transparent");
        }
	
	//CHASERS
	/*
	chasers = 3;
	for (i = 0; i < chasers; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var aishape = new ShapeAI(50,50,openPoint.mX,openPoint.mY,mGame,"","/images/monster/red_monster.png","","chaser");
		mGame.addToShapeArray(aishape);
        }
	*/
	
	//RED MONSTERS TO COUNT
	monsters = 20;
	for (i = 0; i < monsters; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,"","/images/monster/red_monster.png","","countee");
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
