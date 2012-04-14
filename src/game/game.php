/******************************************************************** 

Game Class: this class should be the different games by instantiating a genre and hopefully other things. 

********************************************************************/
 
var Game = new Class(
{
        initialize: function()
        {
	  	//quiz
                this.mQuiz = new Quiz(this,scoreNeeded,countBy,startNumber,endNumber);
		
		mGenre = new GenreAdventure(this, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance);


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
        mGame = new Game();
        
	//the game
        mApplication = new Application();


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


