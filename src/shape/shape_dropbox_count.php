var ShapeDropboxCount = new Class(
{

Extends: ShapeDropbox,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        },

	update: function(delta)
	{
		this.mQuestion = this.mGame.mQuiz.getQuestion();
		this.parent(delta);
	}

});

