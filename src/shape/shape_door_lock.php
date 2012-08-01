var ShapeDoorLock = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message,srcOpen)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
		this.mOpen = false;	
		this.mSrcClosed = src;
		this.mSrcOpen = srcOpen;
        },

	onCollision: function(col)
	{
		//is it a key? and if so does the key have answer to locked door?
		if (col.mMountee.mMessage == 'key' && col.mMountee.mQuestion.getAnswer() == this.mQuestion.getAnswer()) 
		{
			this.mOpen = true;	
			this.setSrc(this.mSrcOpen);
		}
		

		if (col == this.mGame.mControlObject)
		{
        		if (this.mOpen)
                	{
                        	this.enterDoor();
                	}
		}
	},
   	
	enterDoor: function()
        {
                this.mGame.mOn = false;
                window.location = "/src/database/goto_next_level.php";
        }

});

