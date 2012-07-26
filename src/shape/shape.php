/**********************************************
public methods
----------------------

//set methods
void update(deltaTime); //update the the shape using the delta time of game update

void setPosition(x,y) //
void setText(text);  //set text inside shape
void setBackgroundColor(color);
void setMessage(message);
 
//get methods
x getPositionX();
y getPositionY();
text getText();
bool getVisibility();
color getBackgroundColor(); 
message getMessage();

/**********************************************
protected methods
----------------------

void sortGameVisibility(x,y);
void draw();

************************************************/

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
	
		//mounting	just one mountpoint for now.
		this.mMountable = false;
		this.mMountee;
		this.mMounter;

		this.mMountPoint = new Array();	
		
		this.mMountPoint[0] = new Point2D();

		if (navigator.appName == "Microsoft Internet Explorer" || navigator.appName == "Opera")
        	{
			this.mMountPoint[0].mX = -5;
			this.mMountPoint[0].mY = -41;
        	}
        	else
       	 	{
			this.mMountPoint[0].mX = -5;
			this.mMountPoint[0].mY = -58;
        	}
		
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
        },

/******************** PUBLIC METHODS *************/

/****** UTILITY METHODS ******************/
	reset: function()
	{
     		//reset collidable to true
                if (this.mMessage == "dropbox_question")
                {
                	if (this.mMountee)
                        {
                        	this.mMountee.mCollidable = true;
                                this.mMountee.mMounter = 0;
                                this.mMountee = 0;
                        }
                }
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
                        	if (this.mMountee)
                       		{
                                	this.mMountee.setQuestion(this.mGame.mQuiz.getQuestion());
                        	}
			}
                }

	},

	onCollision: function(col)
	{
		this.mPosition.mX = this.mPositionOld.mX;
                this.mPosition.mY = this.mPositionOld.mY;

		if (this == this.mGame.mControlObject)
		{
			if (col.mMessage == "question")
			{
				if (this.mMountee)
                 		{
                                	if (this.mMountee.mQuestion.getAnswer() == col.mQuestion.getAnswer())
                                	{
                                        	this.correctAnswer();
                                	}
                                	else
                                	{
                                        	this.incorrectAnswer();
                                	}
				}
                        }
		}
		else
		{
   			this.mCollisionOn = false;
                	this.setVisibility(false);
		}		 
		
		//mount an item if mountable
                if (col == this.mGame.mControlObject && this.mMountable == true)
                {
                        if (col != this.getTimeoutShape())
                        {
                                //first unmount  if you have something
                                if (col.mMountee)
                                {
                                        col.unMount(col.mMountee,0);
                                }
                                //then mount
                                col.mount(this,0);
                        }
                }
	},

	correctAnswer: function()
        {
		if (this == this.mGame.mControlObject)
		{
			mApplication.log('correctAnswer:' + this.mMessage);
			this.mGame.correctAnswer();
                
			//set text of control object
                	if (this.mGame.mQuiz)
                	{
                        	//set the control objects question object
                        	this.setQuestion(this.mGame.mQuiz.getQuestion());
                        	if (this.mMountee)
                        	{
                                	this.mMountee.setQuestion(this.mGame.mQuiz.getQuestion());
                        	}
                	}
		}
		else
		{
		}
        },

        incorrectAnswer: function()
        {
                this.mGame.resetGame();
        },

	

	update: function(delta)
	{
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
			this.mPosition.mX += this.mMounter.mMountPoint[0].mX;
			this.mPosition.mY += this.mMounter.mMountPoint[0].mY;
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

	mount: function(mountee,mountpoint)
	{
		this.mMountee = mountee;
		this.mMountee.mountedBy(this,mountpoint);
	},

	mountedBy: function(mounter,mountpoint)
	{
		this.mCollidable = false;
		this.mCollisionOn = false;
		this.mMounter = mounter;
	},

	unMount: function(mountee,mountpoint)
	{
		mountee.setTimeoutShape(this);
		mountee.mCollidable = true;	
		mountee.mCollisionOn = true;	
		mountee.mMounter = 0;
		this.mMountee = 0;
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
		if (this.mMountee)
		{
			this.mMountee.setVisibility(b);
		}

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
