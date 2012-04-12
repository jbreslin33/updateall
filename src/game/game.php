/******************************************************************** 

Game lass: This class handles Time, ticks and keystrokes. and is ex-
tended to create different games.

********************************************************************/
 
var Game = new Class(
{
        initialize: function(tickLength)
        {
                //window size
                this.mWindow = window.getSize();

                //ticks
                this.mTickLength = tickLength;
                
                //key pressed
                this.mKeyLeft = false;
                this.mKeyRight = false;
                this.mKeyUp = false;
                this.mKeyDown = false;
                this.mKeyStop = false;

                mGenre = new GenreAdventure(this, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance);
                
                //this will be used for resetting to
                mGenre.resetGame();

        },

        update: function()
        {
                if (mGenre.mGenreOn)
                {
                        //update genre
                        mGenre.update(); 
                
                        var t=setTimeout("mGame.update()",20)
                }
        },

        log: function(msg)
        {
                setTimeout(function()
                {
                        throw new Error(msg);
                }, 0);
        },

        //CONTROLS
        keyDown: function(event)
        {
                if (event.key == 'left')
                {
                        mGame.mKeyLeft = true;
                }
                if (event.key == 'right')
                {
                        mGame.mKeyRight = true;
                }
                if (event.key == 'up')
                {
                        mGame.mKeyUp = true;
                }
                if (event.key == 'down')
                {
                        mGame.mKeyDown = true;
                }
        },
        
        keyUp: function(event)
        {       
                if (event.key == 'left')
                {
                        mGame.mKeyLeft = false;
                }
                if (event.key == 'right')
                {
                        mGame.mKeyRight = false;
                }
                if (event.key == 'up')
                {
                        mGame.mKeyUp = false;
                }
                if (event.key == 'down')
                {
                        mGame.mKeyDown = false;
                }
        }
});

window.addEvent('domready', function()
{
        //the game
        mGame = new Game(<?php echo "$tickLength);"; ?>


        //keys
        document.addEvent("keydown", mGame.keyDown);
        document.addEvent("keyup", mGame.keyUp);

        //start updating
        mGame.update();
}
);

window.onresize = function(event)
{
        mGame.mWindow = window.getSize();
}


