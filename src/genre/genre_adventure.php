var GenreAdventure = new Class(
{

Extends: GenreAction,

        initialize: function(application, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance)
        {

                //application
        	this.parent(application, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance);
         
        },

        //update
        update: function()
        {
		this.parent();
        }

});

