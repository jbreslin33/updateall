var ApplicationGameDungeonGreaterLessEqual = new Class(
{

Extends: ApplicationGameDungeon,

	initialize: function()
	{
       		this.parent();

		//create symbols 
		this.createSymbols();

		//create kids
		this.createKids();
	},

	createMonstersToCount: function()
	{
/*
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
*/
	},
 createControlObject: function(image_source)
        {
                //*******************CONTROL OBJECT
                mGame.mControlObject = new Player(50,50,400,300,mGame,mQuiz.getSpecificQuestion(0),image_source,"","controlObject");
                mGame.mControlObject.mHideOnQuestionSolved = false;
                mGame.mControlObject.createMountPoint(0,-5,-41);

                //set animation instance
                mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

                mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');

                mGame.addToShapeArray(mGame.mControlObject);
                mGame.mControlObject.showQuestionObject(false);

        },

        createQuestionShapes: function(image_source)
        {
  		//QUESIONS
        	for (i = 0; i < scoreNeeded; i++)
        	{
                	var a = 1 + Math.floor(Math.random()*kidsRedShirt);
                	var b = 1 + Math.floor(Math.random()*kidsGreenShirt);

                	if (a > b)
                	{
                        	mQuiz.mQuestionArray.push(new QuestionCompare('The red shirt kids are greater, less than or equal to the green shirt kids?', 'greater_than',a,b));
                	}
                	if (a < b)
                	{
                        	mQuiz.mQuestionArray.push(new QuestionCompare('The red shirt kids are greater, less than or equal to the green shirt kids?', 'less_than',a,b));
                	}
                	if (a == b)
                	{
                        	mQuiz.mQuestionArray.push(new QuestionCompare('The red shirt kids are greater, less than or equal to the green shirt kids?', 'equal_to',a,b));
                	}
        	}

/*
                count = 0;
                for (i = 0; i < numberOfRows; i++)
                {
                        var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                        var shape;
                        mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(count),image_source,"","question"));
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
*/
        },

        createChasers: function(image_source)
        {
                for (i = 0; i < 0; i++)
                {
                        var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                        var shape = new ShapeChaser(50,50,openPoint.mX,openPoint.mY,mGame,"",image_source,"","chaser");
                        mGame.addToShapeArray(shape);
                }

        },

        createKey: function(image_source)
        {
                var keyQuestion = new Question('Pick up key.',"key");
                mQuiz.mQuestionArray.push(keyQuestion);

                openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var key = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,keyQuestion,"/images/key/key_dungeon.gif","","key");
                key.setVisibility(false);
                key.mShowOnlyOnQuizComplete = true;
                key.mMountable = true;
                key.setHideOnQuestionSolved(false);
                mGame.addToShapeArray(key);
        },

        createDoor: function(image_source_closed,image_source_open)
        {
                var doorQuestion = new Question('Open door with key.',"door");
                mQuiz.mQuestionArray.push(doorQuestion);

                var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var door = new ShapeDoor(50,50,openPoint.mX,openPoint.mY,mGame,doorQuestion,image_source_closed,"","door",image_source_open);
                door.mUrl = '/src/database/goto_next_level.php';
                door.mOpenOnQuestionSolved = true;
                mGame.addToShapeArray(door);

                //create question shapes
                this.createQuestionShapes("/images/treasure/gold_coin_head.png");

                //create chasers
                this.createChasers("/images/monster/red_monster.png");
        },

	createSymbols: function()
	{
		//SYMBOLS
        	var greaterThan = new Shape(50,50,300,200,mGame,new Question('','greater_than'),"/images/symbols/greater_than.png","","greater_than");
        	mGame.addToShapeArray(greaterThan);
        	greaterThan.setHideOnQuizComplete(true);
        	greaterThan.setHideOnQuestionSolved(false);

        	var lessThan = new Shape(50,50,400,200,mGame,new Question('','less_than'),"/images/symbols/less_than.png","","less_than");
        	mGame.addToShapeArray(lessThan);
        	lessThan.setHideOnQuizComplete(true);
        	lessThan.setHideOnQuestionSolved(false);

        	var equalTo = new Shape(50,50,500,200,mGame,new Question('','equal_to'),"/images/symbols/equal.png","","equal_to");
        	mGame.addToShapeArray(equalTo);
        	equalTo.setHideOnQuizComplete(true);
        	equalTo.setHideOnQuestionSolved(false);
	},

	createKids: function()
	{
        	//KIDS RED SHIRT
        	for (i = 0; i < kidsRedShirt + 1; i++)
        	{
                	var shape;
                	mGame.addToShapeArray(shape = new ShapeCompare(50,50,75,50 + (i * 50),mGame,'',"/images/characters/kid_red_shirt/kid_red_shirt.png","",'a',i));
                	shape.showQuestion(false);
        	}

        	//KIDS GREEN SHIRT
        	for (i = 0; i < kidsGreenShirt + 1; i++)
        	{
                	var shape;
                	mGame.addToShapeArray(shape = new ShapeCompare(50,50,650,50 + (i * 50),mGame,'',"/images/characters/kid_green_shirt/kid_green_shirt.png","",'b',i));
                	shape.showQuestion(false);
        	}
	}

});

