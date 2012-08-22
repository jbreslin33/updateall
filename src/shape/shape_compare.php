var ShapeCompare = new Class(
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
		
		if (this.mMessage == 'a')
		{
			numberToCount = this.mGame.mQuiz.getQuestion().getVariableA();

			if (numberToCount >= this.mNumber)
			{
                        	this.setVisibility(true);
			}
			else
			{
                		this.setVisibility(false);
			}
			mApplication.log('a:' + numberToCount + 'i:' + this.mNumber);
		}

		if (this.mMessage == 'b')
		{
			numberToCount = this.mGame.mQuiz.getQuestion().getVariableB();

			if (numberToCount >= this.mNumber)
			{
                        	this.setVisibility(true);
			}
			else
			{
                		this.setVisibility(false);
			}
//			mApplication.log('b:' + numberToCount + 'i:' + this.mNumber);
		}
        }
});

