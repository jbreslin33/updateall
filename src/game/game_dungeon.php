var GameDungeon = new Class(
{

Extends: Game,

        initialize: function(name, leftBounds, rightBounds, topBounds, bottomBounds, numberOfChasers)
        {
                //application
                this.parent(name, leftBounds, rightBounds, topBounds, bottomBounds);

                //chasers
                this.mNumberOfChasers = numberOfChasers;
        },

        //update
        update: function()
        {
                this.parent();
          
		//door entered?
                this.checkForDoorEntered();
        },

	resetGame: function()
	{
		//reset collidable to true
                for (i=0; i < this.mShapeArray.length; i++)
                {
                        //set every shape to spawn position
                        this.mShapeArray[i].mPosition.mX = this.mShapeArray[i].mPositionSpawn.mX;
                        this.mShapeArray[i].mPosition.mY = this.mShapeArray[i].mPositionSpawn.mY;
                        this.mShapeArray[i].setVisibility(true);
                }

                for (i=0; i < this.mShapeArray.length; i++)
		{
			if (this.mShapeArray[i].mCollidable == true)
			{
                		this.mShapeArray[i].mCollisionOn = true;
			}
		}

	},

	openTheDoors: function()
	{
 		//open the doors
                for (i=0; i < this.mShapeArray.length; i++)
                {
                	if (this.mShapeArray[i].mBackgroundColor == 'green')
                        {
                        	this.mShapeArray[i].setBackgroundColor('white');
                        }
                }
	},

        isEndOfGame: function()
        {
        
	},

        checkForDoorEntered: function()
        {
        
	},
	
	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);
		
		if (col1.mMessage == "controlObject" && col2.mMessage == "chaser")
                {
	                //feedback
                        this.setFeedback("Try again.");

                        //this deletes and then recreates everthing.
                        this.resetGame();
                }
 	}).protect()

});



