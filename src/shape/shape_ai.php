var ShapeAI = new Class(
{

Extends: ShapeRelative,

        initialize: function(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType,message,game)
        {
        	this.parent(src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,drawType,message,game);
		
		//ai
                this.mAiCounter = 0;
                this.mAiCounterDelay = 10;
        },
        
        update: function(delta)
        {
                //run ai                
                if (this.mAiCounter > this.mAiCounterDelay)
                {       
                        this.ai();
                        this.mAiCounter = 0;
                }
                this.mAiCounter++;
       
		this.parent(delta);
        },

	ai: function()
        {
        	var direction = Math.floor(Math.random()*9)     
       
		if (direction == 0) //left
                {
                	this.mKeyX = -1;
                        this.mKeyY = 0;
                }
                if (direction == 1) //right
                {
                        this.mKeyX = 1;
                        this.mKeyY = 0;
                }
                if (direction == 2) //up
                {
                        this.mKeyX = 0;
                        this.mKeyY = -1;
                }
                if (direction == 3) //down
                {
                        this.mKeyX = 0;
                        this.mKeyY = 1;
                }
                if (direction == 4) //leftup
                {
                        this.mKeyX = -.5;
                        this.mKeyY = -.5;
                }
                if (direction == 5) //leftdown
                {
                        this.mKeyX = -.5;
                      	this.mKeyY = .5;
                }
                if (direction == 6) //rightup
                {
                        this.mKeyX = .5;
                        this.mKeyY = -.5;
                }
               	if (direction == 7) //rightdown
                {
                        this.mKeyX = .5;
                        this.mKeyY = .5;
                }
                if (direction == 8) //stop
                {
                        this.mKeyX = 0;
               	        this.mKeyY = 0;
                }
	} 

});

