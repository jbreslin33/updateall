/*************************************************************

Base Class for Game Genre. Extend this for Action Games...then
extend that for Adventure games. etc. 

**************************************************************/

var Genre = new Class(
{
        initialize: function(application, scoreNeeded, countBy, startNumber, endNumber)
        {
                //application
                this.mApplication = application;        

		//quiz	
		this.mQuiz = new Quiz(this,scoreNeeded,countBy,startNumber,endNumber);

        },

        update: function()
        {
        
	}

});


