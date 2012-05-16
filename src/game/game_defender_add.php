var GameDefenderAdd = new Class(
{

Extends: Game,

        initialize: function(name, leftBounds, rightBounds, topBounds, bottomBounds, numberOfChasers, scoreNeeded, startNumber, endNumber)
        {

                //application
                this.parent(name, leftBounds, rightBounds, topBounds, bottomBounds);

                //chasers
                this.mNumberOfChasers = numberOfChasers;

		//the quiz
        	this.mQuiz = new QuizAdd(scoreNeeded,startNumber,endNumber);

        },

        //update
        update: function()
        {
                this.parent();
        },

	createWorld: function()
	{

                //create walls
                this.createLeftWall();
                this.createRightWall();
                this.createTopWall();
                this.createBottomWall();

                //create Shapes
                this.createShapes();
		
		//create quiz shapes
		for (i = 0; i <= 9; i++)
                {
			var openPoint = this.getOpenPoint2D(-400,400,-300,300,50,4);
		  	this.addToShapeArray(new ShapeQuestion("",50,50,openPoint.mX,openPoint.mY,i,"yellow","","question",this,this.mQuiz.getSpecificQuestion(i)));
                }

	},

	createShapes: function()
	{
		//control object
                this.mControlObject = new ShapeCenter("",50,50,100,100,"","blue","","controlObject",this);
		this.addToShapeArray(this.mControlObject);
	
                for (i = 0; i < this.mNumberOfChasers; i++)
                {
			var openPoint = this.getOpenPoint2D(-400,400,-300,300,50,4);
			this.addToShapeArray(new ShapeAI("",50,50,openPoint.mX,openPoint.mY,"","red","","chaser",this));
                }
	},

	resetGame: function()
	{
		//reset collidable to true
                for (i=0; i < this.mShapeArray.length; i++)
                {
                        //set every shape to spawn position
                        this.mShapeArray[i].mPosition.mX = this.mShapeArray[i].mPositionSpawn.mX;
                        this.mShapeArray[i].mPosition.mY = this.mShapeArray[i].mPositionSpawn.mY;
                        this.mShapeArray[i].setVisibility(true);
                }

                for (i=0; i < this.mShapeArray.length; i++)
		{
			if (this.mShapeArray[i].mCollidable == true)
			{
                		this.mShapeArray[i].mCollisionOn = true;
			}
		}

		//let's reset all quiz stuff right here.
		this.mQuiz.reset();
	},

   	createLeftWall: function()
        {
                for (i = this.mTopBounds + 50; i <= this.mBottomBounds - 50; i = i + 50)
                {
                        this.addToShapeArray(new ShapeRelative("",50,50,this.mLeftBounds,i,"","black","","wall",this));
                }
        },

        createRightWall: function()
        {
                for (i = this.mTopBounds; i <= this.mBottomBounds; i = i + 50)
                {
                        this.addToShapeArray(new ShapeRelative("",50,50,this.mRightBounds,i,"","black","","wall",this));
                }
        
        },

        createTopWall: function()
        {
                for (i = this.mLeftBounds + 50; i <= this.mRightBounds - 50; i = i + 50)
                {
                        this.addToShapeArray(new ShapeRelative("",50,50,i,this.mTopBounds,"","black","","wall",this));
                }
        },

        createBottomWall: function()
        {
                for (i = this.mLeftBounds + 50; i <= this.mRightBounds - 50; i = i + 50)
                {
                        this.addToShapeArray(new ShapeRelative("",50,50,i,this.mBottomBounds,"","black","","wall",this));
                }
        },

        checkForScoreNeeded: function()
        {
                if (this.mQuiz.getScore() == this.mQuiz.getScoreNeeded())
                {
                        this.mOn = false;
			this.setFeedback("YOU WIN!!!");
                        window.location = "../database/goto_next_math_level.php"
                }
        },

	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);
		
		if (col1.mMessage == "controlObject" && col2.mMessage == "question")
		{
                       	if (col1.mInnerHTML == col2.mQuestion.getAnswer()) 
			{
				//call quiz correct Answer yourself
				this.mQuiz.correctAnswer();
	
                                col2.mCollisionOn = false;
                                col2.setVisibility(false);

                                //feedback
                                this.setFeedback("Correct!");
                        }
                        else
                        {
                                //feedback
                                this.setFeedback("Try again.");

                                //this deletes and then recreates everthing.
                                this.resetGame();
                        }
                }

		if (col1.mMessage == "controlObject" && col2.mMessage == "chaser")
                {
	                //feedback
                        this.setFeedback("Try again.");

                        //this deletes and then recreates everthing.
                        this.resetGame();
                }
 	}).protect(),

 	checkKeys: (function()
        {
		this.parent();

                //space
                if (mApplication.mKeySpace == true)
                {
		//	this.mControlObject.setText("s");
                }

                if (mApplication.mKey0 == true)
                {
			this.mControlObject.setText("0");
                }
                if (mApplication.mKey1 == true)
                {
			this.mControlObject.setText("1");
                }
                if (mApplication.mKey2 == true)
                {
			this.mControlObject.setText("2");
                }
                if (mApplication.mKey3 == true)
                {
			this.mControlObject.setText("3");
                }
                if (mApplication.mKey4 == true)
                {
			this.mControlObject.setText("4");
                }
                if (mApplication.mKey5 == true)
                {
			this.mControlObject.setText("5");
                }
                if (mApplication.mKey6 == true)
                {
			this.mControlObject.setText("6");
                }
                if (mApplication.mKey7 == true)
                {
			this.mControlObject.setText("7");
                }
                if (mApplication.mKey8 == true)
                {
			this.mControlObject.setText("8");
                }
                if (mApplication.mKey9 == true)
                {
			this.mControlObject.setText("9");
                }

 	}).protect()

});



