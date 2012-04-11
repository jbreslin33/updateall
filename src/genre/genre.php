/*************************************************************

Base Class for Game Genre. Extend this for Action Games...then
extend that for Adventure games. etc. 

**************************************************************/

var Genre = new Class(
{
        initialize: function(game, scoreNeeded, countBy, startNumber, endNumber)
        {
                //application
                this.mGame = game;        

		//quiz	
		this.mQuiz = new Quiz(this,scoreNeeded,countBy,startNumber,endNumber);

        },

        update: function()
        {
        
	}

});


