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
		this.mQuiz.create();

                //create walls
                this.createLeftWall();
                this.createRightWall();
                this.createTopWall();
                this.createBottomWall();

	},

	createShapes: function()
	{
		this.parent();
		
                for (i = 0; i < this.mNumberOfChasers; i++)
                {
                        this.setUniqueSpawnPosition();
                        new ShapeCollidableAI(this,"",50,50,this.mPositionXArray[this.mProposedX],this.mPositionYArray[this.mProposedY],"","red","","relative");

                }
	},

	resetGame: function()
	{
              	//set collidable to true
                for (i=0; i < this.mShapeArray.length; i++)
                {
                        //set every shape to spawn position
                        this.mShapeArray[i].mPositionX = this.mShapeArray[i].mSpawnPositionX;
                        this.mShapeArray[i].mPositionY = this.mShapeArray[i].mSpawnPositionY;
                        this.mShapeCollidableArray[i].setVisibility(true);
                }

                for (i=0; i < this.mShapeCollidableArray.length; i++)
		{
                	this.mShapeCollidableArray[i].mCollisionOn = true;
		}

                //this.mControlObject.mPositionX = 0;
                //this.mControlObject.mPositionY = 0;

		//let's reset all quiz stuff right here.
		this.mQuiz.reset();

		//set text of control object
		this.mControlObject.setText(this.mQuiz.mCount);

	},

   	createLeftWall: function()
        {
                for (i = this.mTopBounds + 50; i <= this.mBottomBounds - 50; i = i + 50)
                {
                        new ShapeCollidable(this,"",1,50,this.mLeftBounds,i,"","black","","relative");
                }
        },

        createRightWall: function()
        {
                var greenDoorCount = 0; 
                for (i = this.mTopBounds; i <= this.mBottomBounds; i = i + 50)
                {
                        if (greenDoorCount == 0 || greenDoorCount == 1)
                        {
                                new ShapeCollidable(this,"",1,50,this.mRightBounds,i,"","green","","relative");
                        }       
                        else
                        {       
                                new ShapeCollidable(this,"",1,50,this.mRightBounds,i,"","black","","relative");
                        }
                        greenDoorCount++;
                }
        
        },

        createTopWall: function()
        {
                for (i = this.mLeftBounds + 50; i <= this.mRightBounds - 50; i = i + 50)
                {
                        new ShapeCollidable(this,"",50,1,i,this.mTopBounds,"","black","","relative");
                }
        },

        createBottomWall: function()
        {
                for (i = this.mLeftBounds + 50; i <= this.mRightBounds - 50; i = i + 50)
                {
                        new ShapeCollidable(this,"",50,1,i,this.mBottomBounds,"","black","","relative");
                }
        },

	evaluateCollision: function(mId1,mId2)
        {
                if (this.mShapeArray[mId1] == this.mControlObject)
                {
                               	if (this.mQuiz.checkAnswer(this.mShapeArray[mId2].mInnerHTML))			 
				{
                                        this.mShapeCollidableArray[mId2].mCollisionOn = false;
                                        this.mShapeArray[mId2].setVisibility(false);

                                        //feedback
                                       	this.mHud.setFeedback("Correct!"); 
                                }
                                else
                                {
                                        //feedback
                                       	this.mHud.setFeedback("Wrong! Try again."); 

                                        //this deletes and then recreates everthing.
                                        this.resetGame();
                                }
                               
				//get a new question 
				this.mQuiz.newQuestion();
                                
				//set text of control object
				this.mControlObject.setText(this.mQuiz.mCount);

                                this.mQuiz.newAnswer();
                                this.mShapeArray[mId1].mPositionX = this.mShapeArray[mId1].mOldPositionX;
                                this.mShapeArray[mId1].mPositionY = this.mShapeArray[mId1].mOldPositionY;

                                this.mShapeArray[mId2].mPositionX = this.mShapeArray[mId2].mOldPositionX;
                                this.mShapeArray[mId2].mPositionY = this.mShapeArray[mId2].mOldPositionY;
                }
                else
                {
                        this.mShapeArray[mId1].mPositionX = this.mShapeArray[mId1].mOldPositionX;
                        this.mShapeArray[mId1].mPositionY = this.mShapeArray[mId1].mOldPositionY;

                        this.mShapeArray[mId2].mPositionX = this.mShapeArray[mId2].mOldPositionX;
                        this.mShapeArray[mId2].mPositionY = this.mShapeArray[mId2].mOldPositionY;
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
				this.mHud.setFeedback("YOU WIN!!!");
                                window.location = "../database/goto_next_math_level.php"
                        }
                }
        }

});



