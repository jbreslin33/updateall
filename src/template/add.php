<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../template/header.php");

//query the game table, eventually maybe there will be more than one result here which would be a choice of game for that level.
$query = "select score_needed, number_of_addends, addend_min, addend_max from math_add_levels where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$scoreNeeded = 0;
$addendMin = 0;
$addendMax = 0;
$numberOfAddends = 0;

//get numer of rows
$num = pg_num_rows($result);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
        //get row
        $row = pg_fetch_row($result);

        //fill php vars from db
        $scoreNeeded = $row[0];
        $numberOfAddends = $row[1];
        $addendMin = $row[2];
        $addendMax = $row[3];
}

?>

<script language="javascript">

var skill = "<?php echo $skill; ?>";
var nextLevel = <?php echo $nextLevel; ?>;
var scoreNeeded = <?php echo $scoreNeeded; ?>;
var addendMin = <?php echo $addendMin; ?>;
var addendMax = <?php echo $addendMax; ?>;
var numberOfAddends = <?php echo $numberOfAddends; ?>;

</script>

<script type="text/javascript" src="../math/point2D.php"></script>
<script type="text/javascript" src="../game/game.php"></script>
<script type="text/javascript" src="../game/game_defender_quiz.php"></script>
<script type="text/javascript" src="../application/application.php"></script>
<script type="text/javascript" src="../shape/shape.php"></script>
<script type="text/javascript" src="../shape/shape_relative.php"></script>
<script type="text/javascript" src="../shape/shape_question.php"></script>
<script type="text/javascript" src="../shape/shape_center.php"></script>
<script type="text/javascript" src="../shape/shape_ai.php"></script>
<script type="text/javascript" src="../div/div.php"></script>
<script type="text/javascript" src="../question/question.php"></script>
<script type="text/javascript" src="../quiz/quiz.php"></script>
<script type="text/javascript" src="../quiz/quiz_add.php"></script>

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
        mGame = new GameDefenderQuiz(skill);

	//control object
        mGame.mControlObject = new ShapeCenter("",50,50,100,100,"","blue","","controlObject",mGame);
        mGame.addToShapeArray(mGame.mControlObject);


        var openPoint = mGame.getOpenPoint2D(-400,400,-300,300,50,4);
        mGame.addToShapeArray(new ShapeRelative("../../images/helicopter/helicopter_forward.png",50,50,openPoint.mX,openPoint.mY,"","","","chaser",mGame));

	chasers = 1;
                
        for (i = 0; i < chasers; i++)
        {
        	var openPoint = mGame.getOpenPoint2D(-400,400,-300,300,50,4);
                mGame.addToShapeArray(new ShapeAI("",50,50,openPoint.mX,openPoint.mY,"","red","","chaser",mGame));
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

	mQuiz = new QuizAdd(scoreNeeded,addendMin,addendMax,numberOfAddends,mGame);
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
