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

                //time
                this.mTimeSinceEpoch = 0;
                this.mLastTimeSinceEpoch = 0;
                this.mTimeSinceLastInterval = 0;

	 	//shape Array
                this.mShapeArray = new Array();

		//quiz	
		this.mQuiz = new Quiz(this,scoreNeeded,countBy,startNumber,endNumber);

        },

        update: function()
        {
                //get time since epoch and set lasttime
                e = new Date();
                this.mLastTimeSinceEpoch = this.mTimeSinceEpoch;
                this.mTimeSinceEpoch = e.getTime();

                //set timeSinceLastInterval as function of timeSinceEpoch and LastTimeSinceEpoch diff
                this.mTimeSinceLastInterval = this.mTimeSinceEpoch - this.mLastTimeSinceEpoch;
        
	}

});


