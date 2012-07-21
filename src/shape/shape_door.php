var ShapeDoor = new Class(
{

Extends: Shape,

        initialize: function(game,drawType,question,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message)
        {
        	this.parent(game,drawType,question,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message);
		this.mOpen = false;	
		this.mSrcClosed = src;
		this.mSrcOpen = "/images/doors/door_open.png";
		//mApplication.log('con:' + this.mSrcOpen);
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
				mApplication.log('change pic:' + this.mSrcOpen);
				this.mOpen = true;
			}
		}
/*
		else
		{
			if (this.mOpen)
			{
				this.mOpen = false;
				this.setSrc(this.mSrcClosed);
			}

		}
*/
        }

});

