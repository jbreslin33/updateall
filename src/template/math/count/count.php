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
$username = $_SESSION["username"];
$mathlevel = $_SESSION["math_level"];
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
var mathlevel = "<?php echo $mathlevel; ?>";
var skill = "<?php echo $skill; ?>";
var scoreNeeded = <?php echo $scoreNeeded; ?>;
var countBy = <?php echo $countBy; ?>;
var startNumber = <?php echo $startNumber; ?>;
var endNumber = <?php echo $endNumber; ?>;
var nextLevel = <?php echo $nextLevel; ?>;

</script>

</style>

<script type="text/javascript" src="../../../math/point2D.php"></script>
<script type="text/javascript" src="../../../bounds/bounds.php"></script>
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
	//APPLICATION
        mApplication = new Application();
 
        //KEYS
        document.addEvent("keydown", mApplication.keyDown);
        document.addEvent("keyup", mApplication.keyUp);
	
	//BOUNDS AND HUD COMBO
        mBounds = new Bounds(60,735,380,35);
	var y = 35;
        northBoundsABCANDYOU = new Shape(120, y,  0,  0,"","","","red","boundary");
	northBoundsABCANDYOU.setText('ABCANDYOU');		

        northBoundsUser = new Shape     (120, y,120,  0,"","","","orange","boundary");
	northBoundsUser.setText('User : ' + username);		

        northBoundsMathLevel = new Shape(120, y,240,  0,"","","","yellow","boundary");
	northBoundsMathLevel.setText('Math Level : ' + mathlevel);		
        
	northBoundsScore = new Shape    (120, y,360,  0,"","","","LawnGreen","boundary");
	northBoundsScore.setText('Score : ');		

	northBoundsScoreNeeded = new Shape    (120, y,480,  0,"","","","cyan","boundary");
	northBoundsScoreNeeded.setText('Score Needed : ');		
        
	northBoundsGameName = new Shape (170, y,600,  0,"","","","#DBCCE6","boundary");
	northBoundsGameName.setText(skill);		

	eastBounds  = new Shape         ( 10, 50,760, 35,"","","","#F8CDF8","boundary");
	eastBounds  = new Shape         ( 10, 50,760, 85,"","","","#F6C0F6","boundary");
	eastBounds  = new Shape         ( 10, 50,760,135,"","","","#F5B4F5","boundary");
	eastBounds  = new Shape         ( 10, 50,760,185,"","","","#F6C0F6","boundary");
	eastBounds  = new Shape         ( 10, 50,760,235,"","","","#F5B4F5","boundary");
	eastBounds  = new Shape         ( 10, 50,760,285,"","","","#F3A8F3","boundary");
	eastBounds  = new Shape         ( 10, 50,760,335,"","","","#F19BF1","boundary");
	eastBounds  = new Shape         ( 10, 20,760,385,"","","","#F08EF0","boundary");
        
	southBoundsQuestion = new Shape (770, y,  0,405,"","","","violet","boundary");

	westBounds  = new Shape         ( 10, 50,  0, 35,"","","","#F8CDF8","boundary");
	westBounds  = new Shape         ( 10, 50,  0, 85,"","","","#F6C0F6","boundary");
	westBounds  = new Shape         ( 10, 50,  0,135,"","","","#F5B4F5","boundary");
	westBounds  = new Shape         ( 10, 50,  0,185,"","","","#F6C0F6","boundary");
	westBounds  = new Shape         ( 10, 50,  0,235,"","","","#F5B4F5","boundary");
	westBounds  = new Shape         ( 10, 50,  0,285,"","","","#F3A8F3","boundary");
	westBounds  = new Shape         ( 10, 50,  0,335,"","","","#F19BF1","boundary");
	westBounds  = new Shape         ( 10, 20,  0,385,"","","","#F08EF0","boundary");
	
	//GAME
        mGame = new GameDungeonQuiz(skill);

	//CHASERS
	chasers = 3;
	for (i = 0; i < chasers; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var aishape = new ShapeAI(50,50,openPoint.mX,openPoint.mY,mGame,"","../../../../images/monster/red_monster.png","","chaser");
		mGame.addToShapeArray(aishape);
        }

	//DOOR
       	var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
	var door = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,new Question("DOOR","../../../database/goto_next_math_level.php"),"","green","wall");
	mGame.addToShapeArray(door);
       
	//QUIZ 
	mQuiz = new Quiz(scoreNeeded);
	mGame.mQuiz = mQuiz;

	//QUESTIONS FOR QUIZ
	for (i = startNumber; i <= endNumber; i = i + countBy)
        {
        	var question = new Question('What number comes after ' + i + '?', i + countBy);      
                mQuiz.mQuestionArray.push(question);
        }
               
	//QUESTION SHAPES 
        count = 0;
        for (i = startNumber + countBy; i <= endNumber; i = i + countBy)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape;
               	mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(count),"../../../../images/treasure/gold_coin_head.png","","question"));
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
	
 	//CONTROL OBJECT
        mGame.mControlObject = new Shape(50,50,400,300,mGame,mQuiz.getSpecificQuestion(0),"../../../../images/characters/wizard.png","","controlObject");

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
//      mGame.mControlObject.mAnimation.mAnimationArray[1][1] = "../../../../images/characters/wizard_south.png";
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

	//RESET GAME TO START
	mGame.resetGame();

        //START UPDATING
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
