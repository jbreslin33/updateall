var GenreAdventure = new Class(
{

Extends: Genre,

        initialize: function(application, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance)
        {

                //application
		this.parent(application);
         
	        //On_Off
                this.mGenreOn = true;
        
                //shapes
                this.mPositionXArray = new Array();
                this.mPositionYArray = new Array();

                this.mSlotPositionXArray = new Array();
                this.mSlotPositionYArray = new Array();
                
                //shape Array
                this.mShapeArray = new Array();
        
                //control object
                this.mControlObject;
                
                //score
                this.mScore = 0; 
                this.mScoreNeeded = scoreNeeded;

                //count
                this.mCountBy = countBy;
                this.mStartNumber = startNumber;
                this.mEndNumber = endNumber; 

                //speed
                this.mSpeed = speed;
        
                //chasers
                this.mNumberOfChasers = numberOfChasers;

                //dimensions
                this.mLeftBounds = leftBounds;
                this.mRightBounds = rightBounds;
                this.mTopBounds = topBounds;
                this.mBottomBounds = bottomBounds;

                //collisionDistnce
                this.mCollisionDistance = collisionDistance;    
                
                //proposed positions    
                this.mProposedX = 0;
                this.mProposedY = 0;
                
                // id counter
                this.mIdCount = 0;


                //dimensions
                this.mDefaultSpriteSize = 50;

                //fill possible spawnPosition Arrays
                this.fillSpawnPositionArrays();
        
                //create Shapes 
                this.createShapes();

                //create walls          
                this.createLeftWall();
                this.createRightWall();
                this.createTopWall();
                this.createBottomWall();
        },

        update: function()
        {
		//check Keys from application
		this.checkKeys();

                //move shapes   
                for (i = 0; i < this.mShapeArray.length; i++)
                {
                        this.mShapeArray[i].update();
                }
                
                //door entered?
                this.checkForDoorEntered();

                //reality check for out of bounds for avatar
                this.checkForOutOfBounds();
        
                //check collisions
                this.checkForCollisions();
        
                //check for end game
                this.checkForScoreNeeded();
        
                //save old positions
                this.saveOldPositions();
        },

	checkKeys: function()
        {
                //left
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = -1;
                        this.mControlObject.mKeyY = 0;
                }
                //right
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = 1;
                        this.mControlObject.mKeyY = 0;
                }
                //up
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = 0;
                        this.mControlObject.mKeyY = -1;
                }
                //down
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKeyX = 0;
                        this.mControlObject.mKeyY = 1;
                }
                //left_up
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = -.5;
                        this.mControlObject.mKeyY = -.5;
                }
                //left_down
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKeyX = -.5;
                        this.mControlObject.mKeyY = .5;
                }
                //right_up
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = .5;
                        this.mControlObject.mKeyY = -.5;
                }
                //right_down
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKeyX = .5;
                        this.mControlObject.mKeyY = .5;
                }
                //all up...stop
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKeyX = 0;
                        this.mControlObject.mKeyY = 0;
                }
        },

        checkForOutOfBounds: function()
        {
                for (i = 0; i < this.mShapeArray.length; i++)
                {       
                        if (this.mShapeArray[i].mPositionX < this.mLeftBounds)
                        {
                                this.mShapeArray[i].mPositionX = this.mLeftBounds;              
                        }
                        if (this.mShapeArray[i].mPositionX > this.mRightBounds)
                        {
                                this.mShapeArray[i].mPositionX = this.mRightBounds;
                        }
                        if (this.mShapeArray[i].mPositionY < this.mTopBounds)
                        {
                                this.mShapeArray[i].mPositionY = this.mTopBounds;
                        }
                        if (this.mShapeArray[i].mPositionY > this.mBottomBounds)
                        {
                                this.mShapeArray[i].mPositionY = this.mBottomBounds;
                        }
                }
        },

        fillSpawnPositionArrays: function()
        {
                for (i=this.mLeftBounds + this.mDefaultSpriteSize / 2; i <= this.mRightBounds - this.mDefaultSpriteSize / 2; i = i + this.mDefaultSpriteSize)
                {       
                        this.mPositionXArray.push(i);   
                }
        
                for (i=this.mTopBounds + this.mDefaultSpriteSize / 2; i <= this.mBottomBounds - this.mDefaultSpriteSize / 2; i = i + this.mDefaultSpriteSize)
                {       
                        this.mPositionYArray.push(i);   
                }
        },

        createShapes: function()
        {
                //control object        
                new Shape(this,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,100,100,true,false,"",true,true,false,"","blue","","middle");
                for (i = this.mStartNumber + this.mCountBy; i <= this.mEndNumber; i = i + this.mCountBy)
                {
                        this.setUniqueSpawnPosition();
                        new Shape(this,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,this.mPositionXArray[this.mProposedX],this.mPositionYArray[this.mProposedY],false,true,i,true,true,false,"","yellow","","relative");
                }

                for (i = 0; i < this.mNumberOfChasers; i++)
                {
                        this.setUniqueSpawnPosition();
                        new Shape(this,"",this.mDefaultSpriteSize,this.mDefaultSpriteSize,this.mPositionXArray[this.mProposedX],this.mPositionYArray[this.mProposedY],false,true,"",true,true,true,"","red","","relative");
                        
                }

		//hud
		
        },

        setUniqueSpawnPosition: function()
        {
                //get random spawn element
                this.mProposedX = Math.floor(Math.random()*this.mPositionXArray.length);
                this.mProposedY = Math.floor(Math.random()*this.mPositionYArray.length);

                for (r= 0; r < this.mShapeArray.length; r++)
                {
                        if (this.mPositionXArray[this.mProposedX] == this.mShapeArray[r].mPositionX && this.mPositionYArray[this.mProposedY] == this.mShapeArray[r].mPositionY)
                        {
                                r = 0;
                                this.mProposedX = Math.floor(Math.random()*this.mPositionXArray.length);
                                this.mProposedY = Math.floor(Math.random()*this.mPositionYArray.length);
                        }
                        if (r > 0)
                        {       
                                if (
                                Math.abs(this.mPositionXArray[this.mProposedX] - this.mShapeArray[r-1].mPositionX) > 350 
                                        ||
                                Math.abs(this.mPositionYArray[this.mProposedY] - this.mShapeArray[r-1].mPositionY) > 350                        
                                ) 
                                {
                                        r = 0;
                                        this.mProposedX = Math.floor(Math.random()*this.mPositionXArray.length);
                                        this.mProposedY = Math.floor(Math.random()*this.mPositionYArray.length);
                                }
                                if (
                                Math.abs(this.mPositionXArray[this.mProposedX] - this.mControlObject.mPositionX) < 100 
                                        && 
                                Math.abs(this.mPositionYArray[this.mProposedY] - this.mControlObject.mPositionY) < 100                  
                                ) 
                                {
                                        r = 0;
                                        this.mProposedX = Math.floor(Math.random()*this.mPositionXArray.length);
                                        this.mProposedY = Math.floor(Math.random()*this.mPositionYArray.length);
                                }
                        }
                }
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

        saveOldPositions: function()
        {
                //save old positions
                for (i = 0; i < this.mShapeArray.length; i++)
                {
                        //record old position to use for collisions or whatever you fancy
                        this.mShapeArray[i].mOldPositionX = this.mShapeArray[i].mPositionX;
                        this.mShapeArray[i].mOldPositionY = this.mShapeArray[i].mPositionY;
                }
        },

        checkForCollisions: function()
        {
                for (s = 0; s < this.mShapeArray.length; s++)
                {
                        var x1 = this.mShapeArray[s].mPositionX;
                        var y1 = this.mShapeArray[s].mPositionY;
 
                        for (i = 0; i < this.mShapeArray.length; i++)
                        {
                                if (this.mShapeArray[i] == this.mShapeArray[s])
                                {
                                        //skip
                                }
                                else
                                {
                                        if (this.mShapeArray[i].mCollisionOn == true && this.mShapeArray[s].mCollisionOn == true)
                                        {
                                                var x2 = this.mShapeArray[i].mPositionX;              
                                                var y2 = this.mShapeArray[i].mPositionY;              
                
                                                var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                                                if (distSQ < this.mCollisionDistance) 
                                                {
                                                        this.evaluateCollision(this.mShapeArray[s].mId,this.mShapeArray[i].mId);                      
                                                }
                                        }
                                }       
                        }
                }
        },

        evaluateCollision: function(mId1,mId2)
        {
                if (this.mShapeArray[mId1] == this.mControlObject)
                {

                        if (this.mShapeArray[mId2].mIsQuestion)
                        {
                                if (this.mShapeArray[mId2].mAnswer == this.mAnswer)
                                {
                                        this.mCount = this.mCount + this.mCountBy;  //add to count
                                        this.mScore++;
                                        this.mShapeArray[mId2].mCollisionOn = false;
                                        this.mShapeArray[mId2].setVisibility(false);
                
                                        //feedback      
                                        document.getElementById("feedback").innerHTML="Correct!";
                                }
                                else
                                {
                                        //feedback 
                                        document.getElementById("feedback").innerHTML="Wrong! Try again.";
        
                                        //this deletes and then recreates everthing.    
                                        this.resetGame();
                                }
                                this.newQuestion();
                                this.newAnswer();
                                this.printScore();
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

        //questions
        newQuestion: function()
        {
                //set question
                this.mQuestion = this.mCount;
                document.getElementById("question").innerHTML="Question: " + this.mQuestion;
                //this.mShapeArray[0].mMesh.innerHTML=this.mCount;
		this.mShapeArray[0].setText(this.mCount);
        },

        //new answer
        newAnswer: function()
        {
                this.mAnswer = this.mCount + this.mCountBy;
        },
        
	//Score
        printScore: function()
        {
                document.getElementById("score").innerHTML="Score: " + this.mScore;
                document.getElementById("scoreNeeded").innerHTML="Score Needed: " + this.mScoreNeeded;
        },

        checkForScoreNeeded: function()
        {
                if (this.mScore == this.mScoreNeeded)
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
                if (this.mScore == this.mScoreNeeded)
                {
                        if (this.mControlObject.mPositionX > this.mRightBounds - this.mDefaultSpriteSize / 2 &&
                        this.mControlObject.mPositionY > this.mTopBounds &&
                        this.mControlObject.mPositionY < this.mTopBounds + this.mDefaultSpriteSize * 2) 
                        
                        {
                                this.mGenreOn = false;
                                document.getElementById("feedback").innerHTML="YOU WIN!!!";
                                window.location = "../database/goto_next_math_level.php"
                        }
                }
        },

        //reset
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
                this.mScore = 0;

                //game
                this.mQuestion = this.mCount;

                //count
                this.mCount = this.mStartNumber;
        
                //answer
                this.newAnswer();
		this.mShapeArray[0].setText(this.mCount);
        }
});


