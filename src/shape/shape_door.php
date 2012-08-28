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
//door should if no question just open when quiz is complete.
//if it has a question then it simply should open if answers match
//
        update: function(delta)
        {
		if (this.mQuestion)
		{
	                if (this.mGame.mQuiz.isQuizComplete())
                	{
                        	if (this.mCollisionOn == false)
                        	{
                                	this.mCollisionOn = true;
                                	this.setVisibility(true);
                        	}
                	}
                	else
                	{
                        	if (this.mCollisionOn == true)
                        	{
                                	this.mCollisionOn = false;
                                	this.setVisibility(false);
                        	}
			}
		}
		else
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
        },
	
	onCollision: function(col)
	{
		if (this.mQuestion)
		{
 			if (col == this.mGame.mControlObject)
                	{
                        	if (col.mQuestion)
                        	{
                                	if (this.mQuestion.getAnswer() == col.mQuestion.getAnswer())
                                	{
                                        	this.correctAnswer();
                                	}
                                	else
                                	{
                                        	this.incorrectAnswer();
                                	}
                        	}
			}
		}
		else
		{
			if (col == this.mGame.mControlObject)
			{
        			if (this.mOpen)
                		{
                			if (this.mGame.mQuiz)
                        		{
                        			if (this.mGame.mQuiz.isQuizComplete())
                                		{
                                			this.enterDoor();
                                		}
                        		}
                		}
			}
		}
	},
   	
	enterDoor: function()
        {
                this.mGame.mOn = false;
                window.location = this.getQuestion().getAnswer();
        }

});

