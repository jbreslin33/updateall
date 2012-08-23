var PlayerNoGobble = new Class(
{

Extends: Player,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	onCollision: function(col)
	{
		this.parent(col);
	
		//no mounts just old school question on question.
		if (col.mQuestion && this.mQuestion)
		{
			if (this.mQuestion.getAnswer() == col.mQuestion.getAnswer())
			{
  				//mark as correct
                                col.correctAnswer();
                        }
                        else
        		{
                                col.incorrectAnswer();
                        }
			this.mPosition.mX = this.mPositionSpawn.mX;
			this.mPosition.mY = this.mPositionSpawn.mY;
		}
	}
});

