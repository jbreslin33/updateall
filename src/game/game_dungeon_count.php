var GameDungeonCount = new Class(
{

Extends: Game,

        initialize: function(application, game, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance)
        {

                //application
                this.parent(application, game, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance);

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

                //create walls
                this.createLeftWall();
                this.createRightWall();
                this.createTopWall();
                this.createBottomWall();

	},

	createShapes: function()
	{
                //control object
                new Shape(this,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,100,100,true,false,"",true,true,false,"","blue","","middle");
                for (i = this.mQuiz.mStartNumber + this.mQuiz.mCountBy; i <= this.mQuiz.mEndNumber; i = i + this.mQuiz.mCountBy)
                {
                        this.setUniqueSpawnPosition();
                        new Shape(this,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,this.mPositionXArray[this.mProposedX],this.mPositionYArray[this.mProposedY],false,true,i,true,true,false,"","yellow","","relative");
                }

                for (i = 0; i < this.mNumberOfChasers; i++)
                {
                        this.setUniqueSpawnPosition();
                        new Shape(this,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,this.mPositionXArray[this.mProposedX],this.mPositionYArray[this.mProposedY],false,true,"",true,true,true,"","red","","relative");

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

                        if (this.mShapeArray[i].mCollidable == true)
                        {
                                this.mShapeArray[i].mCollisionOn = true;
                                this.mShapeArray[i].setVisibility(true);
                        }
                }
                this.mControlObject.mPositionX = 0;
                this.mControlObject.mPositionY = 0;

		//let's reset all quiz stuff right here.
		this.mQuiz.reset();

		//set text of control object
		this.mControlObject.setText(this.mQuiz.mCount);

	},

   	createLeftWall: function()
        {
                for (i = this.mTopBounds + this.mDefaultSpriteSize; i <= this.mBottomBounds - this.mDefaultSpriteSize; i = i + this.mDefaultSpriteSize)
                {
                        new Shape(this,"",1,this.mDefaultSpriteSize,this.mLeftBounds,i,false,false,"",true,true,false,"","black","","relative");
                }
        },

        createRightWall: function()
        {
                var greenDoorCount = 0; 
                for (i = this.mTopBounds; i <= this.mBottomBounds; i = i + this.mDefaultSpriteSize)
                {
                        if (greenDoorCount == 0 || greenDoorCount == 1)
                        {
                                new Shape(this,"",1,this.mDefaultSpriteSize,this.mRightBounds,i,false,false,"",true,true,false,"","green","","relative");
                        }       
                        else
                        {       
                                new Shape(this,"",1,this.mDefaultSpriteSize,this.mRightBounds,i,false,false,"",true,true,false,"","black","","relative");
                        }
                        greenDoorCount++;
                }
        
        },

        createTopWall: function()
        {
                for (i = this.mLeftBounds + this.mDefaultSpriteSize; i <= this.mRightBounds - this.mDefaultSpriteSize; i = i + this.mDefaultSpriteSize)
                {
                        new Shape(this,"",this.mDefaultSpriteSize,1,i,this.mTopBounds,false,false,"",true,true,false,"","black","","relative");
                }
        },

        createBottomWall: function()
        {
                for (i = this.mLeftBounds + this.mDefaultSpriteSize; i <= this.mRightBounds - this.mDefaultSpriteSize; i = i + this.mDefaultSpriteSize)
                {
                        new Shape(this,"",this.mDefaultSpriteSize,1,i,this.mBottomBounds,false,false,"",true,true,false,"","black","","relative");
                }
        },

	evaluateCollision: function(mId1,mId2)
        {
                if (this.mShapeArray[mId1] == this.mControlObject)
                {

                        if (this.mShapeArray[mId2].mIsQuestion)
                        {
                                if (this.mShapeArray[mId2].mAnswer == this.mQuiz.mAnswer)
                                {
                                        this.mQuiz.mCount = this.mQuiz.mCount + this.mQuiz.mCountBy;  //add to count
                                        this.mQuiz.incrementScore();
                                        this.mShapeArray[mId2].mCollisionOn = false;
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
                        }
                        else
                        {
                                this.mShapeArray[mId1].mPositionX = this.mShapeArray[mId1].mOldPositionX;
                                this.mShapeArray[mId1].mPositionY = this.mShapeArray[mId1].mOldPositionY;

                                this.mShapeArray[mId2].mPositionX = this.mShapeArray[mId2].mOldPositionX;
                                this.mShapeArray[mId2].mPositionY = this.mShapeArray[mId2].mOldPositionY;
                        }
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
                        if (this.mControlObject.mPositionX > this.mRightBounds - this.mDefaultSpriteSize / 2 &&
                        this.mControlObject.mPositionY > this.mTopBounds &&
                        this.mControlObject.mPositionY < this.mTopBounds + this.mDefaultSpriteSize * 2)

                        {
                                this.mOn = false;
				this.mHud.setFeedback("YOU WIN!!!");
                                window.location = "../database/goto_next_math_level.php"
                        }
                }
        }

});



