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

void protectScrollBars(x,y);
void sortGameVisibility(x,y);
void draw();

************************************************/

var Shape = new Class(
{
        initialize: function(game,drawType,question,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message)
        {
               
		//game so you can know of your world
		this.mGame = game;

		//animation 
		this.mAnimation;

		//drawType
		this.mDrawType = drawType;

		//we are all about questions and answers in this program so everyone contains a question pointer whether you use it or not.	
		this.mQuestion = question; // the question object that contains a question and answer.
		this.mShowQuestionObject = true; //even if we have a valid question object we can shut off showing it.
		this.mShowQuestion = true; //toggles between question or answer text from question object
		
		//mountee
		this.mMountee;
		this.mMounter

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

		//velocity 
		this.mVelocity = new Point2D(0,0);
                
		//keys
		this.mKey = new Point2D(0,0);
                
		//html	
		this.mInnerHTML = innerHTML; 
                
		//background
		this.mBackgroundColor = backgroundColor;
                
		//onclick	
		this.mOnClick = onClick;
              
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
                        this.mMesh.innerHTML = this.mInnerHTML;
                }
		
		if (this.mOnClick != "")
		{
			this.mMesh = document.createElement("b");
			this.mMesh.innerHTML = this.mInnerHTML;
		}

                //back to div   
                this.mDiv.mDiv.appendChild(this.mMesh);
       
		//message ..this can be used for collisions or whatever
		this.mMessage = message;
        },

/******************** PUBLIC METHODS *************/

/****** UTILITY METHODS ******************/

        update: function(delta)
        {
                //update Velocity
                this.mVelocity.mX = this.mKey.mX * delta * this.mSpeed;
                this.mVelocity.mY = this.mKey.mY * delta * this.mSpeed;

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
			this.mPosition.mX += this.mMountOffsetX;
			this.mPosition.mY += this.mMountOffsetY;
		} 
        	
		if (this.mAnimation)
		{	
			this.mAnimation.update(delta);        	
		}
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

	mount: function(mountee,offsetX,offsetY)
	{
		this.mMountee = mountee;

		this.mMountee.mountedBy(this,offsetX,offsetY);
	},

	mountedBy: function(mounter,offsetX,offsetY)
	{
		this.mCollidable = false;
		this.mCollisionOn = false;
		this.mMounter = mounter;
		this.mMountOffsetX = offsetX;
		this.mMountOffsetY = offsetY;
	},

	unMount: function()
	{
		this.mMountee = 0;
	},

/************** SET METHODS ************************/
	setQuestion: function(question)
	{
		this.mQuestion = question;
	},	


	setPosition: function(x,y)
	{
		modx = x+'px';	
		mody = y+'px';
		if (modx != x)
		{
			this.mDiv.mDiv.style.left = modx;
		}
		if (mody != y)
		{
			this.mDiv.mDiv.style.top = mody;
		}	
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
		if (this.mInnerHTML != t)
		{
        		this.mInnerHTML = t;	
			if (this.mSrc == "")
			{
				this.mMesh.innerHTML = this.mInnerHTML;
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

	protectScrollBars: (function(x,y)
	{
                //if off screen then hide it so we don't have scroll bars mucking up controls
                if (x + this.mWidth  + 3 > mApplication.mWindow.x ||
                        y + this.mHeight + 13 > mApplication.mWindow.y)
                {
                        this.setPosition(0,0);
			
			if (this.getVisibility())
			{
                        	this.setVisibility(false);
			}
                }
  	}).protect(),
 	
	sortGameVisibility: (function(x,y)
        {
                if (this.mCollisionOn == true)
                {
                        this.setPosition(x,y);
			if (this.getVisibility() == false) 
			{
                        	this.setVisibility(true);
			}
                }
                else
                {
                        this.setPosition(0,0);
			if (this.getVisibility() == true) 
			{
                        	this.setVisibility(false);
			}
                }
  	}).protect(),

	draw: (function()
	{
		//DRAW TYPES
       		if (this.mDrawType == "")
		{ 
	        	//center image relative to position
                	var posX = this.mPosition.mX - (this.mWidth / 2);
                	var posY = this.mPosition.mY - (this.mHeight / 2);
                	this.setPosition(posX,posY);
	
			this.protectScrollBars(posX,posY);
		}
		if(this.mDrawType == "center")
		{
			this.drawCenter();
		}
		if (this.mDrawType == "relative")
		{
			this.drawRelative();
		}

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
		
  	}).protect(),

	drawCenter: (function()
        {
                //center image relative to position
                //get the offset from control object
                var xdiff = this.mPosition.mX - this.mGame.getControlObject().mPosition.mX;
                var ydiff = this.mPosition.mY - this.mGame.getControlObject().mPosition.mY;

                var posX = xdiff + (mApplication.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (mApplication.mWindow.y / 2) - (this.mHeight / 2);

                this.sortGameVisibility(posX,posY);
                this.setPosition(posX,posY);
  	}).protect(),

	drawRelative: (function()
        {
                //get the offset from control object
                var xdiff = this.mPosition.mX - this.mGame.getControlObject().mPosition.mX;
                var ydiff = this.mPosition.mY - this.mGame.getControlObject().mPosition.mY;

                //center image relative to position
                var posX = xdiff + (mApplication.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (mApplication.mWindow.y / 2) - (this.mHeight / 2);

                this.sortGameVisibility(posX,posY);
                this.protectScrollBars(posX,posY);
  	}).protect()

});

