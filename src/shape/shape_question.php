var ShapeQuestion = new Class(
{

Extends: ShapeRelative,

        initialize: function(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message,game,question)
        {
        	
		this.parent(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message,game);
	
		this.mQuestion = question;	

		this.setText(this.mQuestion.getQuestion());
        }
        
});

