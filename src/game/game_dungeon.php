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

	resetGame: function()
	{
		this.parent();
	},

        //update
        update: function()
        {
                this.parent();
          
		//door entered?
                this.checkForDoorEntered();
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
	
});



