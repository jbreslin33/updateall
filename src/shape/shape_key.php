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
				this.mCollisionOn = true;
				this.setVisibility(true);
				this.mMountable = true;
				mApplication.log('true');
			}
		}
		else
		{
			if (this.mCollisionOn == true)
			{
				this.mCollisionOn = false;
				this.setVisibility(false);
				this.mMountable = false;
				mApplication.log('false');
			}
		}
		
		this.parent(delta);
        }

});

