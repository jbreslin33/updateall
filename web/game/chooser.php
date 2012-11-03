<?php
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_title_mootools.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/db_connect.php");

//db connection
$conn = dbConnect();

include(getenv("DOCUMENT_ROOT") . "/web/game/standard_games_query.php");
?>

<?php
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_sessions.php");
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_game_includes.php");
?>

<!-- HUD VARIABLES    -->
<script language="javascript">
var username = "<?php echo $username; ?>";
</script>

</head>

<body bgcolor="grey">

<script language="javascript">

var mGame;
var mApplication;

window.addEvent('domready', function()
{
	//application to handle time and input
        mApplication = new Application();

	//bounds
        mBounds = new Bounds(60,735,380,35);
        
        //keys
        document.addEvent("keydown", mApplication.keyDown);
        document.addEvent("keyup", mApplication.keyUp);

	mHud = new Hud();
        mHud.mScoreNeeded.setText('<font size="2"> Needed : 1 </font>');
	mHud.mGameName.setText('<font size="2">GAME CHOOSER</font>');

	//the game
        mGame = new Game("Game Chooser");

	//control object
        mGame.mControlObject = new Shape(50,50,400,300,mGame,'',"/images/characters/wizard.png","","controlObject");

 	//set animation instance
        mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

	mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');
        
	mGame.addToShapeArray(mGame.mControlObject);
	
        for (i = 1; i < numberOfRows + 1; i++ )
        {
                var shape;
		x = i * 50 + 400;
                shape = new ShapeDoor(50,50,x,350,mGame,'',picture_closed[i-1],"","door",picture_open[i-1]);
		shape.setOpenDoor(true);
		shape.mUrl = url[i-1]; 
		mApplication.log('mUrl:' + shape.mUrl);
                mGame.addToShapeArray(shape);
        }

	//end create quiz items

	mGame.resetGame();

        //start updating
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
