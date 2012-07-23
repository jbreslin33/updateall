var ShapeCountee = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message,number)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
		this.mNumber = number;	
        },

        update: function(delta)
	{
		this.parent(delta);

		numberToCount = this.mGame.mQuiz.getQuestion().getAnswer();
		//mApplication.log('numberToCount:' + numberToCount);	
		//	mApplication.log('mNumber:' + this.mNumber);	
		if (numberToCount >= this.mNumber)
		{
			//mApplication.log('mNumber:' + this.mNumber);	
                	this.mCollisionOn = true;
                        this.setVisibility(true);
			
		}
		else
		{
                        this.CollisionOn = false;
                	this.setVisibility(false);
		}
        }
});

