var QuestionShape = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)

                //we are all about questions and answers in this program so everyone contains a question pointer whether you use it or not.
                this.mQuestion = question; // the question object that contains a question and answer.
                this.mShowQuestionObject = true; //even if we have a valid question object we can shut off showing it.
                this.mShowQuestion = true; //toggles between question or answer text from question object

        }

});
