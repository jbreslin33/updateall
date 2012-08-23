var AdvanceOnQuizComplete = new Class(
{

Extends: Game,
        initialize: function(skill)
        {
                this.parent(skill)
        },
	
        update: function(delta)
        {

		if (this.mQuiz.isQuizComplete())
		{
			mApplication.log('completed quiz');
                	this.mOn = false;
                	window.location = '/src/database/goto_next_level.php';
		}
		this.parent(delta);
	}
});


