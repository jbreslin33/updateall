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
       	
	//CONTROL OBJECT
        mGame.mControlObject = new Player(50,50,400,300,mGame,mQuiz.getSpecificQuestion(0),"/images/characters/wizard.png","","controlObject");
	mGame.mControlObject.createMountPoint(0,-5,-41);

        //set animation instance
        mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

 	mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');

 	mGame.addToShapeArray(mGame.mControlObject);
        mGame.mControlObject.showQuestionObject(false);

        //numberMount to go on top let's make it small and draw it on top
        var numberMountee = new Shape(100,50,300,300,mGame,mQuiz.getSpecificQuestion(0),"","orange","numberMountee");
	numberMountee.setMountable(true);
	numberMountee.setHideOnDrop(true);
        mGame.addToShapeArray(numberMountee);

        //do the mount
        mGame.mControlObject.mount(numberMountee,0);
        numberMountee.setBackgroundColor("transparent");

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
        for (i = 0; i < scoreNeeded; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape;
               	mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(i),"/images/treasure/gold_coin_head.png","","question"));
		shape.createMountPoint(0,-5,-41);
                shape.showQuestion(false);

		//numberMount to go on top let's make it small and draw it on top 
                var numberMountee = new Shape(1,1,100,100,mGame,mQuiz.getSpecificQuestion(i),"","orange","numberMountee");       
		numberMountee.setMountable(true);
                mGame.addToShapeArray(numberMountee); 
                numberMountee.showQuestion(false);
                
		//do the mount  
		shape.mount(numberMountee,0);
		numberMountee.setBackgroundColor("transparent");
        }
	
	//RED MONSTERS TO COUNT
	monsters = 20;
	tempArray = new Array(); 
	for (i = 0; i < monsters; i++)
        {
       		var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape = new ShapeCountee(50,50,openPoint.mX,openPoint.mY,mGame,"","/images/monster/red_monster.png","","countee",i + 1);
		mGame.addToShapeArray(shape);
		tempArray.push(shape);
        }
	
	//now that you have done getOpenPoint2D which uses mCollidable set these countees to not collidable
	for (i = 0; i < monsters; i++)
	{
		tempArray[i].mCollidable = false;
		tempArray[i].mCollisionOn = false;
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
