var HowMany = new Class(
{

Extends: Game,

	resetGame: function()
	{
		this.parent();
		this.setCountMonsters();
	},

	setCountMonsters: function()
	{
		numberToCount = this.mQuiz.getQuestion().getAnswer();

		for (i=0; i < this.mShapeArray.length; i++)
		{	
			if (this.mShapeArray[i].mMessage == "countee")
			{
				this.mShapeArray[i].mCollisionOn = false;
				this.mShapeArray[i].setVisibility(false);
			}
		}
	
		adding = 0;	
		for (i=0; i < this.mShapeArray.length; i++)
		{	
			if (this.mShapeArray[i].mMessage == "countee")
			{
				if (adding < numberToCount)
				{
					adding++;
					this.mShapeArray[i].mCollisionOn = true;
					this.mShapeArray[i].setVisibility(true);
				}
			}
		}
	},

	evaluateCollision: (function(col1,col2)
        {
		resetCount = false;	
	
                //if you ran into a question shape lets resolve it so that we reset count monsters after the parent does it's stuff so we get proper question info.
                if (col1.mMessage == "controlObject" && col2.mMessage == "question")
                {
                        if (col1.mMountee)
                        {
                                if (col1.mMountee.mQuestion.getAnswer() == col2.mQuestion.getAnswer())
                                {
					resetCount = true;
				}
			}		
		}		
	
	        this.parent(col1,col2);

		if (resetCount)
		{
			this.setCountMonsters();			
		}

 	}).protect()
});



