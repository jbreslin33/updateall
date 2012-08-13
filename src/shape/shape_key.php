var ShapeKey = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message,srcOpen)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

        update: function(delta)
        {

                //run ai
		if (this.mGame.mQuiz.isQuizComplete())
		{
			if (this.mCollisionOn == false)
			{
				if (this.mMounter)
				{
					//do nothing
				}
				else
				{
					if (this.mCollisionOn == false)
					{ 
						mApplication.log('key com');
						this.mCollisionOn = true;
						this.setVisibility(true);
						this.mMountable = true;
					}
				}
			}
		}
		else
		{
			if (this.mCollisionOn == true)
			{
				this.mCollisionOn = false;
				this.setVisibility(false);
				this.mMountable = false;
			}
		}
		
		this.parent(delta);
        }

});

