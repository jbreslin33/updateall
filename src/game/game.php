/******************************************************************** 

Game lass: This class handles Time, ticks and keystrokes. and is ex-
tended to create different games.

********************************************************************/
 
var Game = new Class(
{
        initialize: function(tickLength)
        {

        },

        update: function()
        {
		mApplication.update();	
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


