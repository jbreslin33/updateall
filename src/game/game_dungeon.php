var GameDungeon = new Class(
{

Extends: Game,

        initialize: function(skill)
        {
                //application
                this.parent(skill);
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
//                this.checkForDoorEntered();
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



