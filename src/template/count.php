<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../template/header.php");

//query the game table, eventually maybe there will be more than one result here which would be a choice of game for that level.
$query = "select score_needed, count_by, start_number, end_number from math_games where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
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

var skill = "<?php echo $skill; ?>";
var scoreNeeded = <?php echo $scoreNeeded; ?>;
var countBy = <?php echo $countBy; ?>;
var startNumber = <?php echo $startNumber; ?>;
var endNumber = <?php echo $endNumber; ?>;
var nextLevel = <?php echo $nextLevel; ?>;

</script>

<script type="text/javascript" src="../math/point2D.php"></script>
<script type="text/javascript" src="../game/game.php"></script>
<script type="text/javascript" src="../game/game_dungeon_quiz.php"></script>
<script type="text/javascript" src="../application/application.php"></script>
<script type="text/javascript" src="../shape/shape.php"></script>
<script type="text/javascript" src="../shape/shape_relative.php"></script>
<script type="text/javascript" src="../shape/shape_answer.php"></script>
<script type="text/javascript" src="../shape/shape_center.php"></script>
<script type="text/javascript" src="../shape/shape_ai.php"></script>
<script type="text/javascript" src="../div/div.php"></script>
<script type="text/javascript" src="../question/question.php"></script>
<script type="text/javascript" src="../quiz/quiz.php"></script>
<script type="text/javascript" src="../quiz/quiz_count.php"></script>

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
        mGame = new GameDungeonQuiz(skill);

	//control object
        mGame.mControlObject = new ShapeCenter("",50,50,100,100,"","blue","","controlObject",mGame);
        mGame.addToShapeArray(mGame.mControlObject);

	chasers = 6;
                
        for (i = 0; i < chasers; i++)
        {
        	var openPoint = mGame.getOpenPoint2D(-400,400,-300,300,50,4);
                mGame.addToShapeArray(new ShapeAI("../../images/monster/red_monster.png",50,50,openPoint.mX,openPoint.mY,"","","","chaser",mGame));
        }

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
        mGame.createWall(50,50,"green",400,-250);
        mGame.createWall(50,50,"green",400,-300);

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

	mQuiz = new QuizCount(scoreNeeded,countBy,startNumber,endNumber,mGame);
	mGame.mQuiz = mQuiz;
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
