<html>
<head>

<title>ABC AND YOU</title>

<!-- mootools -->
<script type="text/javascript" src="/src/mootools/mootools-core-1.4.5-full-compat.js"></script>

<?php
include(getenv("DOCUMENT_ROOT") . "/web/login/check_login.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/db_connect.php");

//db connection
$conn = dbConnect();


//query the game table, eventually maybe there will be more than one result here which would be a choice of game for that level.
$query = "select score_needed, count_by, start_number, end_number from counting where level_id = ";
$query .= $_SESSION["next_level_id"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$username = $_SESSION["username"];
$next_level = $_SESSION["next_level"];
$scoreNeeded = 0;
$countBy = 0;
$startNumber = 0;
$endNumber = 0;

//get numer of rows
$num = pg_num_rows($result);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
        //get row
        $row = pg_fetch_row($result);

        //fill php vars from db
        $scoreNeeded = $row[0];
        $countBy = $row[1];
        $startNumber = $row[2];
        $endNumber = $row[3];
}

?>

<script language="javascript">

var username = "<?php echo $username; ?>";
var next_level = "<?php echo $next_level; ?>";
var scoreNeeded = <?php echo $scoreNeeded; ?>;
var countBy = <?php echo $countBy; ?>;
var startNumber = <?php echo $startNumber; ?>;
var endNumber = <?php echo $endNumber; ?>;

</script>


<script type="text/javascript" src="/src/math/point2D.php"></script>
<script type="text/javascript" src="/src/bounds/bounds.php"></script>
<script type="text/javascript" src="/src/game/game.php"></script>
<script type="text/javascript" src="/src/application/application.php"></script>
<script type="text/javascript" src="/src/animation/animation.php"></script>
<script type="text/javascript" src="/src/animation/animation_advanced.php"></script>
<script type="text/javascript" src="/src/shape/shape.php"></script>
<script type="text/javascript" src="/src/shape/shape_door.php"></script>
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
	for (i = startNumber; i <= endNumber; i = i + countBy)
        {
        	var question = new Question('What number comes after ' + i + '?', i + countBy);      
                mQuiz.mQuestionArray.push(question);
        }
 	
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
        mGame.mControlObject.mAnimation.mAnimationArray[2][0] = "/images/characters/wizard_north_east.png";
        mGame.mControlObject.mAnimation.mAnimationArray[3][0] = "/images/characters/wizard_east.png";
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
	var door = new ShapeDoor(50,50,openPoint.mX,openPoint.mY,mGame,new Question("DOOR","/src/database/goto_next_level.php"),"/images/doors/door_closed.png","","door","/images/doors/door_open.png");
	mGame.addToShapeArray(door);
               
	//QUESTION SHAPES 
        count = 0;
        for (i = startNumber + countBy; i <= endNumber; i = i + countBy)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape;
               	mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(count),"/images/treasure/gold_coin_head.png","","question"));
                shape.showQuestion(false);

		//numberMount to go on top let's make it small and draw it on top 
                var numberMountee = new Shape(1,1,100,100,mGame,mQuiz.getSpecificQuestion(count),"","orange","numberMountee");       
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

                count++;
        }
	
	//CHASERS
	chasers = 3;
	for (i = 0; i < chasers; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var aishape = new ShapeAI(50,50,openPoint.mX,openPoint.mY,mGame,"","/images/monster/red_monster.png","","chaser");
		mGame.addToShapeArray(aishape);
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
