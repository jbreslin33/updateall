/******************************************************************** 

Game Class: this class should be the different games by instantiating a genre and hopefully other things. 

********************************************************************/
 
var Game = new Class(
{
        initialize: function(tickLength)
        {
		mGenre = new GenreAdventure(this, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance);

                //this will be used for resetting to
//                mGenre.resetGame();

        },

        update: function()
        {
                if (mGenre.mGenreOn)
                {
                        //update genre
                        mGenre.update();
                        var t=setTimeout("mGame.update()",20)
                }
	}

});

var mGame;
var mApplication;

window.addEvent('domready', function()
{

        //the game
        mGame = new Game(<?php echo "$tickLength);"; ?>
        
	//the game
        mApplication = new Application(<?php echo "$tickLength);"; ?>


        //keys
        document.addEvent("keydown", mApplication.keyDown);
        document.addEvent("keyup", mApplication.keyUp);

        //start updating
        mGame.update();
}
);

window.onresize = function(event)
{
        mApplication.mWindow = window.getSize();
}


