var GameDungeonCount = new Class(
{

Extends: Game,

        initialize: function(name, leftBounds, rightBounds, topBounds, bottomBounds, numberOfChasers, scoreNeeded, countBy, startNumber, endNumber)
        {

                //application
                this.parent(name, leftBounds, rightBounds, topBounds, bottomBounds);

                //chasers
                this.mNumberOfChasers = numberOfChasers;

		//the quiz
        	this.mQuiz = new QuizCount(scoreNeeded,countBy,startNumber,endNumber);

        },

        //update
        update: function()
        {
                this.parent();
          
		//door entered?
                this.checkForDoorEntered();

        },
	
	createWorld: function()
	{
                //create Shapes
                this.createShapes();

		//create quiz shapes
 		for (i = this.mQuiz.mStartNumber + this.mQuiz.mCountBy; i <= this.mQuiz.mEndNumber; i = i + this.mQuiz.mCountBy)
                {
                        this.setUniqueSpawnPosition();
                        this.addToShapeArray(new ShapeRelative("",50,50,this.mPositionXArray[this.mPositionProposed.mX],this.mPositionYArray[this.mPositionProposed.mY],i,"yellow","","question",this));
			
                }

                //create walls
                this.createLeftWall();
                this.createRightWall();
                this.createTopWall();
                this.createBottomWall();

	},

	createShapes: function()
	{
		//control object
                this.mControlObject = new ShapeCenter("",50,50,100,100,"","blue","","controlObject",this);
		this.addToShapeArray(this.mControlObject);
	
                for (i = 0; i < this.mNumberOfChasers; i++)
                {
			p = this.getRandomSpawnPosition();
                          
			this.addToShapeArray(new ShapeAI("",50,50,p.mX,p.mY,"","red","","chaser",this));
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

		//set text of control object
		this.mControlObject.setText(this.mQuiz.getQuestion());

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
                var greenDoorCount = 0; 
                for (i = this.mTopBounds; i <= this.mBottomBounds; i = i + 50)
                {
                        if (greenDoorCount == 0 || greenDoorCount == 1)
                        {
                                this.addToShapeArray(new ShapeRelative("",50,50,this.mRightBounds,i,"","green","","wall",this));
                        }       
                        else
                        {       
                                this.addToShapeArray(new ShapeRelative("",50,50,this.mRightBounds,i,"","black","","wall",this));
                        }
                        greenDoorCount++;
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
                        //open the doors
                        for (i=0; i < this.mShapeArray.length; i++)
                        {
                                if (this.mShapeArray[i].mBackgroundColor == 'green')
                                {
                                        this.mShapeArray[i].setBackgroundColor('white');
                                }
                        }
                }
        },

        checkForDoorEntered: function()
        {
                if (this.mQuiz.getScore() == this.mQuiz.getScoreNeeded())
                {
                        if (this.mControlObject.mPosition.mX > this.mRightBounds - 50 / 2 &&
                        this.mControlObject.mPosition.mY > this.mTopBounds &&
                        this.mControlObject.mPosition.mY < this.mTopBounds + 50 * 2)

                        {
                                this.mOn = false;
				this.setFeedback("YOU WIN!!!");
                                window.location = "../database/goto_next_math_level.php"
                        }
                }
        },
	
	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);
		
		if (col1.mMessage == "controlObject" && col2.mMessage == "question")
		{
                        if (this.mQuiz.submitAnswer(col2.mInnerHTML))
                        {
                                col2.mCollisionOn = false;
                                col2.setVisibility(false);

                                //feedback
                                this.setFeedback("Correct!");

                                //get a new question
                                this.mQuiz.newQuestion();

                                //set text of control object
                                col1.setText(this.mQuiz.mCount);
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
 	}).protect()

});



