<html>
<head>

<title>ABC AND YOU</title>

<!-- mootools -->
<script type="text/javascript" src="/src/mootools/mootools-core-1.4.5-full-compat.js"></script>

<?php
include(getenv("DOCUMENT_ROOT") . "/web/login/check_login.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/db_connect.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/insert_into_games_attempts.php");

//db connection
$conn = dbConnect();


//query the game table, eventually maybe there will be more than one result here which would be a choice of game for that level.
$query = "select question, answer, question_order from questions where level_id = ";
$query .= $_SESSION["next_level_id"];
$query .= " ORDER BY question_order;";


//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$username = $_SESSION["username"];
$next_level = $_SESSION["next_level"];

//get numer of rows which will also be score needed
$numberOfRows = pg_num_rows($result);
$scoreNeeded = pg_num_rows($result);

echo "<script language=\"javascript\">";
echo "var numberOfRows = $numberOfRows;";
echo "var scoreNeeded = $numberOfRows;";
echo "var questions = new Array();";
echo "var answers = new Array();";

echo "</script>";

$counter = 0;
while ($row = pg_fetch_row($result))
{
  	//fill php vars from db
        $questions = $row[0];
        $answers = $row[1];

        echo "<script language=\"javascript\">";

        echo "questions[$counter] = \"$questions\";";
        echo "answers[$counter] = \"$answers\";";
        echo "</script>";
        $counter++;
}


//brian - get current date
$_SESSION["game_start_time"] = date('Y-m-d H:i:s');
$_SESSION["game_over"] = "false";

//brian - attempt a game - still hardcoding game_id = 1
insertIntoGamesAttempts($conn,$_SESSION["game_start_time"],1,$_SESSION["user_id"],$_SESSION["next_level"]);

?>

<script language="javascript">

var curDate = "<?php echo $curDate; ?>";
var username = "<?php echo $username; ?>";
var next_level = "<?php echo $next_level; ?>";

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
<script type="text/javascript" src="/src/shape/shape_ai.php"></script>
<script type="text/javascript" src="/src/shape/shape_chaser.php"></script>
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
	for (i = 0; i < scoreNeeded; i++)
        {
        	var question = new Question(questions[i],answers[i]);      
                mQuiz.mQuestionArray.push(question);
        }

 	
	//CONTROL OBJECT
        mGame.mControlObject = new Player(50,50,400,300,mGame,mQuiz.getSpecificQuestion(0),"/images/characters/wizard.png","","controlObject");
	mGame.mControlObject.mHideOnQuestionSolved = false;
	mGame.mControlObject.createMountPoint(0,-5,-41);

        //set animation instance
        mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

 	mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');

 	mGame.addToShapeArray(mGame.mControlObject);
        mGame.mControlObject.showQuestionObject(false);

        //text question mountee
        var questionMountee = new Shape(100,50,300,300,mGame,mQuiz.getSpecificQuestion(0),"","orange","questionMountee");
	questionMountee.setMountable(true);
	questionMountee.setHideOnDrop(true);
        mGame.addToShapeArray(questionMountee);
	mGame.mControlObject.setStartingMountee(questionMountee);

        //do the mount
        mGame.mControlObject.mount(questionMountee,0);

        questionMountee.setBackgroundColor("transparent");
	questionMountee.showQuestion(true);

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

	//QUESTION SHAPES 
        count = 0;
        for (i = 0; i < numberOfRows; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
               	var shape;
               	mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(count),"/images/treasure/gold_coin_head.png","","question"));
		shape.createMountPoint(0,-5,-41);
                shape.showQuestion(false);

		//numberMount to go on top let's make it small and draw it on top 
                var questionMountee = new Shape(1,1,100,100,mGame,mQuiz.getSpecificQuestion(count),"","orange","questionMountee");       
		questionMountee.setMountable(true);
                mGame.addToShapeArray(questionMountee); 
                questionMountee.showQuestion(false);
                
		//do the mount  
		shape.mount(questionMountee,0);

		questionMountee.setBackgroundColor("transparent");

                count++;
        }
	
	//CHASERS
	chasers = 0;
	for (i = 0; i < chasers; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape = new ShapeChaser(50,50,openPoint.mX,openPoint.mY,mGame,"","/images/monster/red_monster.png","","chaser");
		mGame.addToShapeArray(shape);
        }

	//RESET GAME TO START
	mGame.resetGame();

        //START UPDATING
        var t=setInterval("mGame.update()",32)
		
		//brian - update score in database
		var t=setInterval("mGame.updateScore()",1000)

}
);

window.onresize = function(event)
{
        mApplication.mWindow = window.getSize();
}
</script>

</body>
</html>
