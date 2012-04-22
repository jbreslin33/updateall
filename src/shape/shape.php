var Shape = new Class(
{
        initialize: function(container,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType)
        {
                
                //container for this shape, for the quiz class we pass in game but for hud we pass in hud. the quiz shapes can collide but the hud is independent.
                this.mContainer = container;      
	
		//speed
		this.mSpeed = .1;
	
		//id 
		this.mId = this.mContainer.mIdCount;
		
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
 
                //add to array
                this.mContainer.mShapeArray.push(this);

                //create the movable div that will be used to move image around.        
		this.mDiv = new Div(this);

                this.mMesh;
        
                //create clientImage
                if (this.mSrc)
                {
                        //image to attach to our div "vessel"
                        this.mMesh  = document.createElement("IMG");
                        this.mMesh.id = 'image' + this.mId;
                        this.mMesh.alt = 'image' + this.mId;
                        this.mMesh.title = 'image' + this.mId;   
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
		this.mContainer.mIdCount++;
        
        },
        
        update: function(delta)
        {
                //update Velocity
                this.mVelocityX = this.mKeyX * delta * speed;
                this.mVelocityY = this.mKeyY * delta * speed;

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
       		if (this.mDrawType == 'relative')
		{
			this.drawRelative();
		} 
		if (this.mDrawType == 'middle')
		{
			this.drawCenter();
		}
		if (this.mDrawType == 'normal')
		{
			this.drawNormal();
		}
	},

	drawNormal: function()
	{
                //center image relative to position
                var posX = this.mPositionX - (this.mWidth / 2);
                var posY = this.mPositionY - (this.mHeight / 2);
	
		this.protectScrollBars(posX,posY);
	},

        drawRelative: function()
        {
                //get the offset from control object
                var xdiff = this.mPositionX - this.mContainer.getGame().mControlObject.mPositionX;
                var ydiff = this.mPositionY - this.mContainer.getGame().mControlObject.mPositionY;

                //center image relative to position
                var posX = xdiff + (mApplication.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (mApplication.mWindow.y / 2) - (this.mHeight / 2);
	
		this.sortGameVisibility(posX,posY);
		this.protectScrollBars(posX,posY);
        },

        drawCenter: function()
        {
                //center image relative to position
                //get the offset from control object
                var xdiff = this.mPositionX - this.mContainer.getGame().mControlObject.mPositionX;
                var ydiff = this.mPositionY - this.mContainer.getGame().mControlObject.mPositionY;

                var posX = xdiff + (mApplication.mWindow.x / 2) - (this.mWidth / 2);
                var posY = ydiff + (mApplication.mWindow.y / 2) - (this.mHeight / 2);

                this.setPosition(posX,posY);
        },

	sortGameVisibility: function(x,y)
	{

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
	}
});

