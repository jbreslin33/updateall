var ShapeDoor = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message,srcOpen)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
		this.mOpen = false;	
		this.mSrcClosed = src;
		this.mSrcOpen = srcOpen;
        },

 	updateVelocity: function(delta)
        {
                this.update();
		this.parent(delta);		
        },

        update: function()
        {
                //run ai
		if (this.mGame.mQuiz.isQuizComplete())
		{
			if (this.mOpen == false)
			{
				this.setSrc(this.mSrcOpen);
				this.mOpen = true;
			}
		}
		else
		{
			if (this.mOpen)
			{
				this.setSrc(this.mSrcClosed);
				this.mOpen = false;
			}
		}
        }

});

