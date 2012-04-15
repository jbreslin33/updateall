var GameDungeonCount = new Class(
{

Extends: Game,

        initialize: function(application, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance)
        {

                //application
                this.parent(application, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance);
         
        },

        //update
        update: function()
        {
                this.parent();
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

                //score
                this.mQuiz.mScore = 0;

                //game
                this.mQuiz.mQuestion = this.mQuiz.mCount;

                //count
                this.mQuiz.mCount = this.mQuiz.mStartNumber;

                //answer
                this.mQuiz.newAnswer();
                this.mShapeArray[0].setText(this.mQuiz.mCount);

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
        }

});



