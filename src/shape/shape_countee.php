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
		if (numberToCount >= this.mNumber)
		{
                	this.mCollisionOn = true;
                	this.mCollidable = true;
                        this.setVisibility(true);
		}
		else
		{
                        this.CollisionOn = false;
                	this.mCollidable = false;
                	this.setVisibility(false);
		}
        }
});

