var Dungeon = new Class(
{

Extends: Game,

        initialize: function(skill)
        {
                //application
                this.parent(skill);
        },

	quizComplete: function()
	{
        	//open the doors
               	for (i=0; i < this.mShapeArray.length; i++)
               	{
              		if (this.mShapeArray[i].mSrc == "/images/doors/door_closed.png")
                       	{
                      		this.mShapeArray[i].setSrc("/images/doors/door_open.png");
			}
		}
	},

	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);

		//exit room to next level when you complete quiz		
		if (col1.mMessage == "controlObject" && col2.mMessage == "door")
		{
			if (col2.mSrc == "/images/doors/door_open.png")
			{
				if (this.mQuiz)
				{
                			if (this.mQuiz.isQuizComplete())
					{
                                		this.mOn = false;
                                		window.location = col2.getQuestion().getAnswer(); 
                        		}
				}
			}
		}
 	}).protect()

});



