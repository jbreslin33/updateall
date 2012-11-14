/******************************************
public methods
-----------------

PUBLIC
---------------------------

//set methods

//get methods
controlObject getControlObject();

PRIVATE
---------------------------------

//add methods
void          addToShapeArray          (shape);
void 	      setFeedback(feedback);

***************************************/
<?php
session_start();
?>

var Game = new Class(
{

        initialize: function(skill)
        {
		/************ NAME *******/
		this.mSkill = skill;
		this.score  = 0;

		/************** On_Off **********/
                this.mOn = true;
				
		// may get rid of later and just use mOn
		this.gameOver = false;
                
		/**************** TIME ************/
                this.mTimeSinceEpoch = 0;
                this.mLastTimeSinceEpoch = 0;
                this.mDeltaTime = 0;

		/********* SHAPES *******************/ 
		//control object
                this.mControlObject;
                
		//shape Array
                this.mShapeArray = new Array();


		//FROM NEW GAME

                //create bounds
                this.createBounds(60,735,380,35);

                //create hud
                this.createHud();

                //create quiz
                this.createQuiz();

                //create questions
                this.createQuestions();

                //create control object
                this.createControlObject();

		//create question shapes
		this.createQuestionShapes();

        },
				
	//brian - update score in games_attempts table		
	updateScore: function()
	{
		if(this.gameOver == false)
		{
			var str = this.mQuiz.getScore();
			
			if (str == this.score)
			{
				return;
			}
			
			var xmlhttp;    
			
			if (window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
			  	xmlhttp=new XMLHttpRequest();
			}
			else
			{
				// code for IE6, IE5
			  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
		  	{
			  
			}
			xmlhttp.open("GET","../../src/database/update_score.php?q="+str,true);
			xmlhttp.send();
			
			this.score = str;
		}
	},

	quizComplete: function()
	{	
	  	if(this.gameOver == false)
		{
			var xmlhttp;    
		
			if (window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
		  		xmlhttp=new XMLHttpRequest();
			}
			else
			{
				// code for IE6, IE5
		  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
		  
			}
			xmlhttp.open("GET","../../src/database/set_game_end_time.php",true);
			xmlhttp.send();
		}
	},

        correctAnswer: function(col1,col2)
        {
		if (this.mQuiz)
                {
                	this.mQuiz.correctAnswer();
                }
        },

 	resetGame: function()
        {
		if (this.mQuiz)
		{
			this.mQuiz.reset();
		}
                
		//call reset on all shapes
                for (i=0; i < this.mShapeArray.length; i++)
                {
			this.mShapeArray[i].reset();
		}
	
        },

	/*********************** PUBLIC ***************************/
	getControlObject: function()
	{
		return this.mControlObject;
	},

	/**************** ADD METHODS *************/
	addToShapeArray: function(shape)
	{
		this.mShapeArray.push(shape);
	},
	
        update: function()
        {
                if (this.mOn)
                {
			//get time since epoch and set lasttime
                	e = new Date();
                	this.mLastTimeSinceEpoch = this.mTimeSinceEpoch;
                	this.mTimeSinceEpoch = e.getTime();

                	//set deltatime as function of timeSinceEpoch and LastTimeSinceEpoch diff
                	this.mDeltaTime = this.mTimeSinceEpoch - this.mLastTimeSinceEpoch;
                        
			//check Keys from application
			this.checkKeys();

                	//move shapes   
                	for (i = 0; i < this.mShapeArray.length; i++)
                	{
				this.mShapeArray[i].update(this.mDeltaTime);
                	}
			
			//collision Detection
			this.checkForCollisions();

                	for (i = 0; i < this.mShapeArray.length; i++)
			{
                        	this.mShapeArray[i].updateScreen();
			}	
        
                	//save old positions
                	this.saveOldPositions();
			//var t=setTimeout("mGame.update()",32)

			//check for quiz complete
                	if (this.mQuiz)
               		{
                        	if (this.mQuiz.isQuizComplete())
			        {
					// update score one last time
					mGame.updateScore();
					// set game end time
					mGame.quizComplete();
					// putting this in for now we may not need it
					mGame.gameOver = true;
			        }
                	}
		}
        },

	/****************************** PROTECTED ***************************************/
	

	checkKeys: (function()
        {
                //idle
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = 0;
                        this.mControlObject.mKey.mY = 0;
                }
                //north
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = 0;
                        this.mControlObject.mKey.mY = -1;
                }
                //north_east
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = .5;
                        this.mControlObject.mKey.mY = -.5;
                }
                //east
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = 1;
                        this.mControlObject.mKey.mY = 0;
                }
                //south_east
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == true && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKey.mX = .5;
                        this.mControlObject.mKey.mY = .5;
                }
                //south
                if (mApplication.mKeyLeft == false && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKey.mX = 0;
                        this.mControlObject.mKey.mY = 1;
                }
                //south_west
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == true)
                {
                        this.mControlObject.mKey.mX = -.5;
                        this.mControlObject.mKey.mY = .5;
                }
                //west
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == false && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = -1;
                        this.mControlObject.mKey.mY = 0;
                }
                //north_west
                if (mApplication.mKeyLeft == true && mApplication.mKeyRight == false && mApplication.mKeyUp == true && mApplication.mKeyDown == false)
                {
                        this.mControlObject.mKey.mX = -.5;
                        this.mControlObject.mKey.mY = -.5;
                }
        }).protect(),

        saveOldPositions: (function()
        {
                //save old positions
                for (i = 0; i < this.mShapeArray.length; i++)
                {
                        //record old position to use for collisions or whatever you fancy
                        this.mShapeArray[i].mPositionOld.mX = this.mShapeArray[i].mPosition.mX;
                        this.mShapeArray[i].mPositionOld.mY = this.mShapeArray[i].mPosition.mY;
                        this.mShapeArray[i].mPositionRenderOld.mX = this.mShapeArray[i].mPositionRender.mX;
                        this.mShapeArray[i].mPositionRenderOld.mY = this.mShapeArray[i].mPositionRender.mY;
                }
        }).protect(),

	//this is still ineffiecient because it is checking to see if one coin is colliding with another. when neither is moving.	
	checkForCollisions: (function()
        {
                for (s = 0; s < this.mShapeArray.length; s++)
                {
			if (this.mShapeArray[s].mCollisionOn == true)
			{
			   	//this should now only loop the first for loop thru objects that have moved. which i think will improve efficiency 
			    	if (this.mShapeArray[s].mPosition.mX != this.mShapeArray[s].mPositionOld.mX ||
			        this.mShapeArray[s].mPosition.mY != this.mShapeArray[s].mPositionOld.mY)
			    	{
					for (c = 0; c < this.mShapeArray.length; c++)
					{
						if (this.mShapeArray[c] == this.mShapeArray[s])
						{
							continue;
						}
						if (this.mShapeArray[c].mCollisionOn == true)
						{
                        				var x1 = this.mShapeArray[s].mPosition.mX;
                        				var y1 = this.mShapeArray[s].mPosition.mY;

                        				var x2 = this.mShapeArray[c].mPosition.mX;
                        				var y2 = this.mShapeArray[c].mPosition.mY;
                
                                			var addend1 = x1 - x2;
							addend1 = addend1 * addend1;

                                			var addend2 = y1 - y2;
							addend2 = addend2 * addend2;

                                			var distSQ = addend1 + addend2;
						
                                			var collisionDistance = this.mShapeArray[s].mCollisionDistance + this.mShapeArray[c].mCollisionDistance;
                                			if (distSQ < collisionDistance) 
                                			{
								this.mShapeArray[c].onCollision(this.mShapeArray[s]);	
								this.mShapeArray[s].onCollision(this.mShapeArray[c]);	
                                			}
						}
					}
			   	}
			}
                }
	}).protect(),
	
	getOpenPoint2D: function(xMin,xMax,yMin,yMax,newShapeWidth,spreadFactor)
        {
                while (true)
                {
                        //let's get a random open space...
                        //get the size of the playing field
                        var xSize = xMax - xMin;
                        var ySize = yMax - yMin;

                        //get point that would fall in the size range from above
                        var randomPoint2D = new Point2D( Math.floor( Math.random()*xSize) , Math.floor(Math.random()*ySize));

                        //now add the left and top bounds so that it is on the games actual field
                        randomPoint2D.mX += xMin;
                        randomPoint2D.mY += yMin;

                        //we now need to see if we can make it thru all shapes without a collision
                        var isCollision = false;
                        for (s = 0; s < this.mShapeArray.length; s++)
                        {
                                if (this.mShapeArray[s].mCollidable == true)
                                {
 					var x1 = this.mShapeArray[s].mPosition.mX;
                                        var y1 = this.mShapeArray[s].mPosition.mY;
 
                                        var x2 = randomPoint2D.mX;              
                                        var y2 = randomPoint2D.mY;              
                
                                        var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
                                        var collisionDistanceOfNewShape = newShapeWidth * 6.5;
                                        var collisionDistance = (this.mShapeArray[s].mCollisionDistance + collisionDistanceOfNewShape) * spreadFactor;
                                                
                                        if (distSQ < collisionDistance) 
                                        {
                                                isCollision = true; 
                                        }
                                }
                        }
                        
                        //we have an open point 
                        if (isCollision == false)
                        {
                                return randomPoint2D;
                        }
                } 
 
        },

  	createBounds: function(north,east,south,west)
        {
                mBounds = new Bounds(north,east,south,west);
        },

        createHud: function()
        {
                mHud = new Hud();
                mHud.mScoreNeeded.setText('<font size="2"> Needed : ' + scoreNeeded + '</font>');
                mHud.mGameName.setText('<font size="2">DUNGEON</font>');
        },

        createQuiz: function()
        {
                mQuiz = new Quiz(scoreNeeded);
                this.mQuiz = mQuiz;
        },

        createQuestions: function()
        {
                for (i = 0; i < scoreNeeded; i++)
                {
                        var question = new Question(questions[i],answers[i]);
                        mQuiz.mQuestionArray.push(question);
                }
        },

        createControlObject: function()
        {
                //*******************CONTROL OBJECT
                this.mControlObject = new Player(50,50,400,300,this,mQuiz.getSpecificQuestion(0),"/images/characters/wizard.png","","controlObject");

                //set animation instance
                this.mControlObject.mAnimation = new AnimationAdvanced(this.mControlObject);
                this.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');

		//don't show question object as your mountee will do this.
	       	this.mControlObject.showQuestionObject(false);

		//create mount point
                this.mControlObject.createMountPoint(0,-5,-41);
		
		//add to shape array
                this.addToShapeArray(this.mControlObject);

                //text question mountee
                var questionMountee = new Shape(100,50,300,300,this,mQuiz.getSpecificQuestion(0),"","orange","questionMountee");
                this.addToShapeArray(questionMountee);

                //do the mount
                this.mControlObject.mount(questionMountee,0);

                questionMountee.setBackgroundColor("transparent");
                questionMountee.showQuestion(true);
        },

        createQuestionShapes: function()
        {
    		count = 0;
                for (i = 0; i < numberOfRows; i++)
                {
                        var openPoint = this.getOpenPoint2D(40,735,75,375,50,7);
                        var shape;
                        this.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,this,mQuiz.getSpecificQuestion(count),"/images/treasure/gold_coin_head.png","","question"));
                        shape.createMountPoint(0,-5,-41);
                        shape.showQuestion(false);

                        //numberMount to go on top let's make it small and draw it on top
                        var questionMountee = new Shape(1,1,100,100,this,mQuiz.getSpecificQuestion(count),"","orange","questionMountee");
                        this.addToShapeArray(questionMountee);
                        questionMountee.showQuestion(false);

                        //do the mount
                        shape.mount(questionMountee,0);

                        questionMountee.setBackgroundColor("transparent");

                        count++;
                }
        }
});


