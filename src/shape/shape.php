var Shape = new Class(
{
        initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
               
		//game so you can know of your world
		this.mGame = game;

		//outOfViewPort
		this.mOutOfViewPort = true;

		//animation 
		this.mAnimation;

		//we are all about questions and answers in this program so everyone contains a question pointer whether you use it or not.	
		this.mQuestion = question; // the question object that contains a question and answer.
		this.mShowQuestionObject = true; //even if we have a valid question object we can shut off showing it.
		this.mShowQuestion = true; //toggles between question or answer text from question object
	
		//for the mounter
		this.mMounteeArray = new Array();
		this.mMountPointArray = new Array();	

		//for the mountee
		this.mMountable = false;
		this.mMounter = 0;
		this.mMountPoint = 0;
	
		//timeouts	
		this.mTimeoutShape;
		this.mTimeoutCounter = 0;

		//speed
		this.mSpeed = .1;
		
		//src 
		this.mSrc = src;
               
		//size 
		this.mWidth = width;
                this.mHeight = height;

		//position
		this.mPosition      = new Point2D(spawnX,spawnY);
		this.mPositionOld   = new Point2D(spawnX,spawnY);
		this.mPositionSpawn = new Point2D(spawnX,spawnY);
		this.mPositionRender = new Point2D(spawnX,spawnY);
		this.mPositionRenderOld = new Point2D(spawnX,spawnY);

		//velocity 
		this.mVelocity = new Point2D(0,0);
                
		//keys
		this.mKey = new Point2D(0,0);
                
		//background
		this.mBackgroundColor = backgroundColor;
                
		//onclick	
		this.mOnClick;
              
                //create the movable div that will be used to move image around.        
		this.mDiv = new Div(this);

		//collision on or off
		this.mCollidable = true;
		this.mCollisionOn = true;

                //collisionDistance
                this.mCollisionDistance = this.mWidth * 6.5;

                this.mMesh;
        
                //create clientImage
                if (this.mSrc)
                {
                        //image to attach to our div "vessel"
                        this.mMesh  = document.createElement("IMG");
                        this.mMesh.src  = this.mSrc;
                        this.mMesh.style.width = this.mWidth+'px'; 
                        this.mMesh.style.height = this.mHeight+'px'; 
                }
                
		if (this.mSrc == "")//create paragraph
                {
                	this.mMesh = document.createElement("p");
                }
		
                //back to div   
                this.mDiv.mDiv.appendChild(this.mMesh);
       
		//message ..this can be used for collisions or whatever
		this.mMessage = message;

		//hide on quiz complete??
		this.mHideOnQuizComplete = false;
	
		//hide on question solved
		this.mHideOnQuestionSolved = true;
        },

/******************** PUBLIC METHODS *************/

	createMountPoint: function(slot,x,y)
	{
		this.mMountPointArray[slot] = new Point2D();

		if (navigator.appName == "Microsoft Internet Explorer" || navigator.appName == "Opera")
        	{
			this.mMountPointArray[slot].mX = x;
			this.mMountPointArray[slot].mY = y;
        	}
        	else
       	 	{
			this.mMountPointArray[slot].mX = x;
			this.mMountPointArray[slot].mY = y - 17;
        	}
	},	

/****** UTILITY METHODS ******************/
	reset: function()
	{
                //set every shape to spawn position
                this.mPosition.mX = this.mPositionSpawn.mX;
                this.mPosition.mY = this.mPositionSpawn.mY;
                this.setVisibility(true);

                if (this.mCollidable == true)
                {
                	this.mCollisionOn = true;
                }

                if (this.mGame.mQuiz)
                {
                        //set the control objects question object
			if (this.mGame.mControlObject == this)
			{
                        	this.setQuestion(this.mGame.mQuiz.getQuestion());
                        	if (this.mMounteeArray[0])
                       		{
                                	this.mMounteeArray[0].setQuestion(this.mGame.mQuiz.getQuestion());
                        	}
			}
                }
	},

	onCollision: function(col)
	{
		this.mPosition.mX = this.mPositionOld.mX;
                this.mPosition.mY = this.mPositionOld.mY;

  		//can i mount this thing?
                if (col.mMountable)
                {
                        if (this.mMountPointArray[0])
                        {
                                if (this.mMounteeArray[0])
                                {
                                        this.unMount(0);
                                }
                                this.mount(col,0);
                        }
                }

		var answer = 0;
		var answerCol = 0;

		//get answer for this
		if (this.mQuestion && col.mQuestion)
		{
			answer = this.mQuestion.getAnswer();	
			answerCol = col.mQuestion.getAnswer();	
		
			//compare answers
			if (this.mQuestion.getSolved() == false)
			{
				if (answer == answerCol)
				{
                        		this.correctAnswer();
				}
				else
				{
                			this.incorrectAnswer();
				}
			}
		}

                //send player back to spawn point so he does not collide again. todo:
                //put in a timeout so that once you stop colliding with object it becomes untimed out.
                //this.mPosition.mX = this.mPositionSpawn.mX;
                //this.mPosition.mY = this.mPositionSpawn.mY;
	},

	correctAnswer: function()
        {
		this.mQuestion.setSolved(true);
		if (this.mHideOnQuestionSolved)
        	{
                	this.mCollisionOn = false;
                        this.setVisibility(false);
                }
		
		this.mGame.correctAnswer();
                
		//set text of control object
                if (this.mGame.mQuiz)
                {
                       	//set the control objects question object
                       	this.mGame.mControlObject.setQuestion(this.mGame.mQuiz.getQuestion());
                       	if (this.mGame.mControlObject.mMounteeArray[0])
                       	{
                               	this.mGame.mControlObject.mMounteeArray[0].setQuestion(this.mGame.mQuiz.getQuestion());
                       	}
		}
		
        },

        incorrectAnswer: function()
        {
                this.mGame.resetGame();
        },

	update: function(delta)
	{
		//HIDE ON QUIZ COMPLETE
		if (this.mGame.mQuiz)
		{
			if (this.mGame.mQuiz.isQuizComplete() && this.mHideOnQuizComplete == true)
                	{
                                if (this.mCollisionOn == true)
                                {
					if (this.mMounter == 0)
					{
                                       		this.mCollisionOn = false;
                                       		this.setVisibility(false);
					}
                        	}
                	}
		}

		//IF YOU ARE MOUNTED TURN OFF COLLISION
		if (this.mMounter)
		{
			this.mCollisionOn = false;
		}

		//IF YOU HAVE TIMED OUT ANOTHER SHAPE.... 
		if (this.mTimeoutShape)
		{
			this.mTimeoutCounter++;
			if (this.mTimeoutCounter > 50)
			{
				this.mTimeoutShape = 0;
				this.mTimeoutCounter = 0;	
			}
		}


		this.updateVelocity(delta);
		this.updatePosition();
		this.updateAnimation();

		//IF YOU ARE NOT MOUNTED BY SOMETHING THEN CHECK FOR OUT OF BOUNDS
		if (this.mMounter == 0)
		{	
			this.checkForOutOfBounds();
		}


	},
 
	checkForOutOfBounds: function()
	{
                if (this.mPosition.mY < mBounds.mNorth)
                {
                        this.mPosition.mY = mBounds.mNorth;
                }
                if (this.mPosition.mX > mBounds.mEast)
                {
                        this.mPosition.mX = mBounds.mEast;
                }
                if (this.mPosition.mY > mBounds.mSouth)
                {
                        this.mPosition.mY = mBounds.mSouth;
                }
                if (this.mPosition.mX < mBounds.mWest)
                {
                        this.mPosition.mX = mBounds.mWest;
                }
        },

	updateVelocity: function(delta)
	{
                //update Velocity
                this.mVelocity.mX = this.mKey.mX * delta * this.mSpeed;
                this.mVelocity.mY = this.mKey.mY * delta * this.mSpeed;
	},
	
	updatePosition: function()
	{
                //update position
                this.mPosition.mX += this.mVelocity.mX;
                this.mPosition.mY += this.mVelocity.mY;
              
		//if you have a mounter then move with the mounter with offset
		if (this.mMounter)
		{
			//set this shape to position of it's mounter
			this.mPosition.mX = this.mMounter.mPosition.mX;
			this.mPosition.mY = this.mMounter.mPosition.mY;

			//offset
			this.mPosition.mX += this.mMounter.mMountPointArray[this.mMountPoint].mX;
			this.mPosition.mY += this.mMounter.mMountPointArray[this.mMountPoint].mY;
		} 
	},

	updateAnimation: function()
	{
		if (this.mAnimation)
		{	
			this.mAnimation.update();        	
		}
	},

	updateScreen: function()
	{
		this.draw();
	},

	setSrc: function(src)
	{
                //create clientImage
                if (this.mSrc)
                {
                        //image to attach to our div "vessel"
			this.mSrc = src;
                        this.mMesh.src  = src;
                        this.mMesh.style.width = this.mWidth+'px'; 
                        this.mMesh.style.height = this.mHeight+'px'; 
                }
		else
		{
                        //image to attach to our div "vessel"
			this.mSrc = src;
                        this.mMesh  = document.createElement("IMG");
                        this.mMesh.src  = src;
                        this.mMesh.style.width = this.mWidth+'px'; 
                        this.mMesh.style.height = this.mHeight+'px'; 

		}
	},

	mount: function(mountee,slot)
	{
        	if (mountee != this.getTimeoutShape())
                {
                	//first unmount  if you have something
                        if (this.mMounteeArray[slot])
                        {
                        	this.unMount(0);
                        }
                        
			//then mount
			this.mMounteeArray[slot] = mountee;
			this.mMounteeArray[slot].mountedBy(this,slot);
                }
	},

	mountedBy: function(mounter,slot)
	{
		this.mCollisionOn = false;
		this.mMounter = mounter;
		this.mMountPoint = slot;
	},

	unMount: function(slot)
	{
		this.mMounteeArray[slot].setTimeoutShape(this);

		if (this.mMounteeArray[slot].mCollidable)
		{
			this.mMounteeArray[slot].mCollisionOn = true;
		}

		this.mMounteeArray[slot].mMounter = 0;
		this.mMounteeArray[slot] = 0;	
	},

	setTimeoutShape: function(shape)
	{
		this.mTimeoutShape = shape;		
	},

	getTimeoutShape: function()
	{
		return this.mTimeoutShape;		
	},

/************** SET METHODS ************************/
	setQuestion: function(question)
	{
		this.mQuestion = question;
	},	

	setPosition: function(x,y)
	{
		this.mPosition.mX = x;
		this.mPosition.mY = y;
	},

	setVisibility: function(b)
	{
		if (b)
		{
			if (this.mDiv.mDiv.style.visibility != 'visible')
			{
				this.mDiv.mDiv.style.visibility = 'visible';
			}
		}
		else
		{
			if (this.mDiv.mDiv.style.visibility != 'hidden')
			{
				this.mDiv.mDiv.style.visibility = 'hidden';
			}
		}
	
		//how about your mounted shapes	
		if (this.mMounteeArray[0])
		{
			this.mMounteeArray[0].setVisibility(b);
		}

	},		

	setHideOnQuizComplete: function(b)
	{
		if (b)
		{
			this.mHideOnQuizComplete = true; 
		}
		else 
		{
			this.mHideOnQuizComplete = false; 
		}
	},

	getHideOnQuizComplete: function()
	{
		return this.mHideOnQuizComplete;
	},

	setHideOnQuestionSolved: function(b)
	{
		if (b)
		{
			this.mHideOnQuestionSolved = true; 
		}
		else 
		{
			this.mHideOnQuestionSolved = false; 
		}
	},

	getHideOnQuestionSolved: function()
	{
		return this.mHideOnQuestionSolved;
	},

	setText: function(t)
	{
		if (this.mMesh.innerHTML != t)
		{
			if (this.mSrc == "")
			{
				this.mMesh.innerHTML = t;
			}
		}
	},

	setBackgroundColor: function(c)
	{
		this.mBackgroundColor = c;
		this.mDiv.mDiv.style.backgroundColor = c;
	},

	setMessage: function(message)
	{
		this.mMessage = message;
	},
	
	showQuestionObject: function(toggle)
	{
		this.mShowQuestionObject = toggle;
	},
	
	showQuestion: function(toggle)
	{
		if (toggle)
		{
			this.mShowQuestion = true;
		}
		else
		{
			this.mShowQuestion = false;
		}
	},

/*********** GET METHODS *************/

	getQuestion: function()
	{
		return this.mQuestion;
	},
	
	getVisibility: function()
	{
		if (this.mDiv.mDiv.style.visibility == 'visible')
		{
			return true;
		}
		else
		{
			return false;
		}
		
	},

/*********** PROTECTED MEMBER METHODS *************/
	
	render: function()
	{
		//check for new values if so change render of div	
		if (this.mPositionRenderOld.mX != this.mPositionRender.mX)
		{
			modx = this.mPositionRender.mX+'px';	
			this.mDiv.mDiv.style.left = modx;
		}	
		if (this.mPositionRenderOld.mY != this.mPositionRender.mY)
		{
			mody = this.mPositionRender.mY+'px';	
			this.mDiv.mDiv.style.top = mody;
		}
	},
 	
	draw: function()
	{
        	//center image relative to position set it to mPositionRender
               	this.mPositionRender.mX = this.mPosition.mX - (this.mWidth / 2);
               	this.mPositionRender.mY = this.mPosition.mY - (this.mHeight / 2);
		
		this.render();

		//do we need to change text this frame?
		if (this.mQuestion)
		{
			if (this.mShowQuestionObject == true)
			{
				if (this.mShowQuestion == true)	
				{
					this.setText(this.mQuestion.getQuestion());
				}
				else
				{
					this.setText(this.mQuestion.getAnswer());
				}
			}
		} 
/*
		if (this.mMesh.innerHTML != t)
		{
			if (this.mSrc == "")
			{
				this.mMesh.innerHTML = t;
			}
		}
*/		
		
  	} }); 
