var GameDungeonCount = new Class(
{

Extends: Game,

        initialize: function(name, leftBounds, rightBounds, topBounds, bottomBounds, numberOfChasers)
        {

                //application
                this.parent(name, leftBounds, rightBounds, topBounds, bottomBounds);

                //chasers
                this.mNumberOfChasers = numberOfChasers;
         
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
                        new Shape(this,"",50,50,this.mPositionXArray[this.mProposedX],this.mPositionYArray[this.mProposedY],i,"yellow","","relative","question");
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
                this.mControlObject = new Shape(this,"",50,50,100,100,"","blue","","middle","controlObject");
	
                for (i = 0; i < this.mNumberOfChasers; i++)
                {
                        this.setUniqueSpawnPosition();
                        new ShapeAI(this,"",50,50,this.mPositionXArray[this.mProposedX],this.mPositionYArray[this.mProposedY],"","red","","relative","chaser");

                }
	},

	resetGame: function()
	{
              	//reset collidable to true
                for (i=0; i < this.mShapeArray.length; i++)
                {
                        //set every shape to spawn position
                        this.mShapeArray[i].mPositionX = this.mShapeArray[i].mSpawnPositionX;
                        this.mShapeArray[i].mPositionY = this.mShapeArray[i].mSpawnPositionY;
                        this.mShapeArray[i].setVisibility(true);
                }

                for (i=0; i < this.mShapeArray.length; i++)
		{
			if (this.mShapeArray.mCollidable == true)
			{
                		this.mShapeArray[i].mCollisionOn = true;
			}
		}

                //this.mControlObject.mPositionX = 0;
                //this.mControlObject.mPositionY = 0;

		//let's reset all quiz stuff right here.
		this.mQuiz.reset();

		//set text of control object
		this.mControlObject.setText(this.mQuiz.getQuestion());

	},

   	createLeftWall: function()
        {
                for (i = this.mTopBounds + 50; i <= this.mBottomBounds - 50; i = i + 50)
                {
                        new Shape(this,"",50,50,this.mLeftBounds,i,"","black","","relative","wall");
                }
        },

        createRightWall: function()
        {
                var greenDoorCount = 0; 
                for (i = this.mTopBounds; i <= this.mBottomBounds; i = i + 50)
                {
                        if (greenDoorCount == 0 || greenDoorCount == 1)
                        {
                                new Shape(this,"",50,50,this.mRightBounds,i,"","green","","relative","wall");
                        }       
                        else
                        {       
                                new Shape(this,"",50,50,this.mRightBounds,i,"","black","","relative","wall");
                        }
                        greenDoorCount++;
                }
        
        },

        createTopWall: function()
        {
                for (i = this.mLeftBounds + 50; i <= this.mRightBounds - 50; i = i + 50)
                {
                        new Shape(this,"",50,50,i,this.mTopBounds,"","black","","relative","wall");
                }
        },

        createBottomWall: function()
        {
                for (i = this.mLeftBounds + 50; i <= this.mRightBounds - 50; i = i + 50)
                {
                        new Shape(this,"",50,50,i,this.mBottomBounds,"","black","","relative","wall");
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
                        if (this.mControlObject.mPositionX > this.mRightBounds - 50 / 2 &&
                        this.mControlObject.mPositionY > this.mTopBounds &&
                        this.mControlObject.mPositionY < this.mTopBounds + 50 * 2)

                        {
                                this.mOn = false;
				this.setFeedback("YOU WIN!!!");
                                window.location = "../database/goto_next_math_level.php"
                        }
                }
        },
	
	evaluateCollision: (function(col1,col2)
        {
	/*
                if (col.mMessage == "question")
                {
                        if (this.getGame().mQuiz.submitAnswer(col.mInnerHTML))
                        {
                                col.mCollisionOn = false;
                                col.setVisibility(false);

                                //feedback
                                this.getGame().setFeedback("Correct!");

                                //get a new question
                                this.getGame().mQuiz.newQuestion();

                                //set text of control object
                                this.setText(this.getGame().mQuiz.mCount);
                        }
                        else
                        {
                                //feedback
                                this.getGame().setFeedback("Wrong! Try again.");

                                //this deletes and then recreates everthing.
                                this.getGame().resetGame();
                        }
                }

                if (col.mMessage == "chaser")
                {
                        //feedback
                        this.getGame().setFeedback("Wrong! Try again.");

                        //this deletes and then recreates everthing.
                        this.getGame().resetGame();
                }
*/
                this.parent(col1,col2);
 	}).protect()

});



