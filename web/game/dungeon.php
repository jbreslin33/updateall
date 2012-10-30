<?php
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_top.php");
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_control_object.php");
?>
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
