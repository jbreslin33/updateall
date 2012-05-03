/**********************************************
public methods
----------------------

//set methods
void update(deltaTime); //update the the shape using the delta time of game update

void setPosition(x,y) //
void setText(text);  //set text inside shape
void setVisibility(bool) //can you see it or not
void setBackgroundColor(color);
void setMessage(message);
 
//get methods
x getPositionX();
y getPositionY();
text getText();
bool getVisibility();
color getBackgroundColor(); 
message getMessage();


************************************************/

var Shape = new Class(
{
        initialize: function(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType,message)
        {
                
		//speed
		this.mSpeed = .1;
		
		//src 
		this.mSrc = src;
               
		//size 
		this.mWidth = width;
                this.mHeight = height;

		//position
		this.mPositionX = spawnX;
                this.mPositionY = spawnY;
                this.mOldPositionX = spawnX;
                this.mOldPositionY = spawnY;
                this.mSpawnPositionX = spawnX;
                this.mSpawnPositionY = spawnY;
               
		//velocity 
		this.mVelocityX = 0;
                this.mVelocityY = 0;
                
		//keys
		this.mKeyX = 0;
                this.mKeyY = 0;
                
		//html	
		this.mInnerHTML = innerHTML; 
                
		//background
		this.mBackgroundColor = backgroundColor;
                
		//onclick	
		this.mOnClick = onClick;
              
		//drawType
		this.mDrawType = drawType;
 
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

                //back to div   
                this.mDiv.mDiv.appendChild(this.mMesh);
       
		//message ..this can be used for collisions or whatever
		this.mMessage = message;
        },

        update: function(delta)
        {
                //update Velocity
                this.mVelocityX = this.mKeyX * delta * this.mSpeed;
                this.mVelocityY = this.mKeyY * delta * this.mSpeed;

                //update position
                this.mPositionX += this.mVelocityX;
                this.mPositionY += this.mVelocityY;
                
                this.draw();
        },

	setPosition: function(x,y)
	{
		this.mDiv.mDiv.style.left = x+'px';
		this.mDiv.mDiv.style.top = y+'px';
	},

	setVisibility: function(b)
	{
		if (b)
		{
			this.mDiv.mDiv.style.visibility = 'visible';
		}
		else
		{
			this.mDiv.mDiv.style.visibility = 'hidden';
		}
	},		

	setText: function(t)
	{
        	this.mInnerHTML = t;	
		if (this.mSrc == "")
		{
			this.mMesh.innerHTML = this.mInnerHTML;
		}
	},

	setBackgroundColor: function(c)
	{
		this.mBackgroundColor = c;
		this.mDiv.mDiv.style.backgroundColor = c;
	},

	draw: function()
	{
                //center image relative to position
                var posX = this.mPositionX - (this.mWidth / 2);
                var posY = this.mPositionY - (this.mHeight / 2);
	
		this.protectScrollBars(posX,posY);
	},

	protectScrollBars: function(x,y)
	{
                //if off screen then hide it so we don't have scroll bars mucking up controls
                if (x + this.mWidth  + 3 > mApplication.mWindow.x ||
                        y + this.mHeight + 13 > mApplication.mWindow.y)
                {
                        this.setPosition(0,0);
                        this.setVisibility(false);
                }
	},
 	
	sortGameVisibility: function(x,y)
        {
                if (this.mCollisionOn)
                {
                        this.setPosition(x,y);
                        this.setVisibility(true);
                }
                else
                {
                        this.setPosition(0,0);
                        this.setVisibility(false);
                }
        }

});

