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

	update: function(delta)
        {
                if (this.mGame.mQuiz.isQuizComplete())
                {
                        if (this.mCollisionOn == false)
                        {
                                this.mCollisionOn = true;
                                this.setVisibility(true);
                                this.mMountable = true;
			
				//mountee
				this.mMountee.setVisibility(true);
                        }
                }
                else
                {
                        if (this.mCollisionOn == true)
                        {
                                this.mCollisionOn = false;
                                this.setVisibility(false);
                                this.mMountable = false;
		
				//mountee
				this.mMountee.setVisibility(false);
                        }
                }

                this.parent(delta);
        },

	onCollision: function(col)
	{
		if (col.mMountee.mMesssage == 'key')
		{
			parent.onCollision(col);		
		}		
	},
  
	correctAnswer: function()
	{
		this.mOpen = true;	
		this.setSrc(this.mSrcOpen);

                this.mGame.mOn = false;
                window.location = "/src/database/goto_next_level.php";
	}	 
});

