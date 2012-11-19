var QuestionShape = new Class(
{

Extends: Shape,
	initialize: function(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)
        {
		this.parent(width,height,spawnX,spawnY,game,question,src,backgroundColor,message)

               	//QUESTIONS 
		this.mQuestion = question; // the question object that contains a question and answer.
                this.mShowQuestionObject = true; //even if we have a valid question object we can shut off showing it.
                this.mShowQuestion = true; //toggles between question or answer text from question object

                //hide on question solved
                this.mHideOnQuestionSolved = true;

                //evaluate questions?
                this.mEvaluateQuestions = true;

                //copy question from mounter
                this.mCopyQuestionFromMounter = false;

		//QUIZ
                //hide on quiz complete??
                this.mHideOnQuizComplete = false;

                //show on quiz complete??
                this.mShowOnlyOnQuizComplete = false;
        },

       	onCollision: function(col)
        {
		this.parent(col);

                //try to evaluate questions of collided objects
                this.evaluateQuestions(col)
        }
});
