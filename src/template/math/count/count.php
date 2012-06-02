<?php 
//standard header for most games i hope. it handles some basic html and level db call
include("../headers/header_math.php");

//query the game table, eventually maybe there will be more than one result here which would be a choice of game for that level.
$query = "select score_needed, count_by, start_number, end_number from math_count_levels where level = ";
$query .= $_SESSION["math_level"];
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

</style>

<script type="text/javascript" src="../../../math/point2D.php"></script>
<script type="text/javascript" src="../../../game/game.php"></script>
<script type="text/javascript" src="../../../game/game_dungeon_quiz.php"></script>
<script type="text/javascript" src="../../../application/application.php"></script>
<script type="text/javascript" src="../../../animation/animation.php"></script>
<script type="text/javascript" src="../../../animation/animation_advanced.php"></script>
<script type="text/javascript" src="../../../shape/shape.php"></script>
<script type="text/javascript" src="../../../shape/shape_ai.php"></script>
<script type="text/javascript" src="../../../div/div.php"></script>
<script type="text/javascript" src="../../../question/question.php"></script>
<script type="text/javascript" src="../../../quiz/quiz.php"></script>



</head>

<body bgcolor="grey">

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
	mGame.mControlObject = new Shape(mGame,"",new Question(1,0),"../../../../images/characters/wizard.png",50,50,400,300,"","","","controlObject"); 

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
	
	mGame.mControlObject.mAnimation.mAnimationArray[0][0] = "../../../../images/characters/wizard_north.png";
	mGame.mControlObject.mAnimation.mAnimationArray[1][0] = "../../../../images/characters/wizard_north.png";
	mGame.mControlObject.mAnimation.mAnimationArray[1][1] = "../../../../images/characters/wizard_south.png";
	mGame.mControlObject.mAnimation.mAnimationArray[2][0] = "../../../../images/characters/wizard_north_east.png";
	mGame.mControlObject.mAnimation.mAnimationArray[3][0] = "../../../../images/characters/wizard_east.png";
	mGame.mControlObject.mAnimation.mAnimationArray[4][0] = "../../../../images/characters/wizard_south_east.png";
	mGame.mControlObject.mAnimation.mAnimationArray[5][0] = "../../../../images/characters/wizard_south.png";
	mGame.mControlObject.mAnimation.mAnimationArray[6][0] = "../../../../images/characters/wizard_south_west.png";
	mGame.mControlObject.mAnimation.mAnimationArray[7][0] = "../../../../images/characters/wizard_west.png";
	mGame.mControlObject.mAnimation.mAnimationArray[8][0] = "../../../../images/characters/wizard_north_west.png";

	mGame.addToShapeArray(mGame.mControlObject); 
	mGame.mControlObject.showQuestionObject(false);

	//numberMount to go on top let's make it small and draw it on top 
	var numberMountee = new Shape(mGame,"",new Question(1,0),"",1,1,300,300,startNumber,"orange","","numberMountee");  
	mGame.addToShapeArray(numberMountee); 
	
	//do the mount	
	mGame.mControlObject.mount(numberMountee,-5,-60);
	numberMountee.setBackgroundColor("transparent");

	chasers = 0;
	for (i = 0; i < chasers; i++)
        {
        	var openPoint = mGame.getOpenPoint2D(0,800,0,600,50,4);
                var aishape = new ShapeAI(mGame,"","","../../../../images/monster/red_monster.png",50,50,openPoint.mX,openPoint.mY,"","","","chaser");
		mGame.addToShapeArray(aishape);
        }


	var door = new Shape(mGame,"",new Question(mGame,"../../../database/goto_next_math_level.php"),"",50,50,400,50,"DOOR","green","","wall");	
	mGame.addToShapeArray(door);
        
	mQuiz = new Quiz(scoreNeeded);
	mGame.mQuiz = mQuiz;

	for (i = startNumber; i <= endNumber; i = i + countBy)
        {
        	var question = new Question(i, i + countBy);      
                mQuiz.mQuestionArray.push(question);
        }
                
        count = 0;
        for (i = startNumber + countBy; i <= endNumber; i = i + countBy)
        {
        	var openPoint = mGame.getOpenPoint2D(150,750,50,350,50,4);
                var shape;
               	mGame.addToShapeArray(shape = new Shape(mGame,"",mQuiz.getSpecificQuestion(count),"../../../../images/treasure/gold_coin_head.png",50,50,openPoint.mX,openPoint.mY,i,"","","question"));
                shape.showQuestion(false);

		//numberMount to go on top let's make it small and draw it on top 
                var numberMountee = new Shape(mGame,"",mQuiz.getSpecificQuestion(count),"",1,1,100,100,"","orange","","numberMountee");       
                mGame.addToShapeArray(numberMountee); 
                numberMountee.showQuestion(false);
                
		//do the mount  
                shape.mount(numberMountee,-5,-60);
                numberMountee.setBackgroundColor("transparent");

                count++;
        }
	/******************* BOUNDARY WALLS ***********/
        northBounds = new Shape("","","","",690, 10,100,  0,"","black","","boundary");
        eastBounds  = new Shape("","","","",10 ,410,790,  0,"","black","","boundary");
        southBounds = new Shape("","","","",690, 10,100,400,"","black","","boundary");
        westBounds  = new Shape("","","","", 10,400,100,  0,"","black","","boundary");


        /******************** HUD ********************/
        mQuiz.mQuestionHud    = new Shape("","","","",100,50,0,250,"Question:","violet","","hud");

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
