var ShapeAI = new Class(
{

Extends: Shape,

        initialize: function(game,drawType,question,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message)
        {
        	this.parent(game,drawType,question,src,width,height,spawnX,spawnY,innerHTML,backgroundColor,onClick,message);
		
		//ai
                this.mAiCounter = 0;
                this.mAiCounterDelay = 10;
        },

 	updateVelocity: function(delta)
        {
       		this.update(); 


	        //update Velocity
                this.mVelocity.mX = this.mKey.mX * delta * this.mSpeed;
                this.mVelocity.mY = this.mKey.mY * delta * this.mSpeed;
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
       
		//this.parent(delta);
        },

	ai: function()
        {
        	var direction = Math.floor(Math.random()*9)     
       
		if (direction == 0) //left
                {
                	this.mKey.mX = -1;
                        this.mKey.mY = 0;
                }
                if (direction == 1) //right
                {
                        this.mKey.mX = 1;
                        this.mKey.mY = 0;
                }
                if (direction == 2) //up
                {
                        this.mKey.mX = 0;
                        this.mKey.mY = -1;
                }
                if (direction == 3) //down
                {
                        this.mKey.mX = 0;
                        this.mKey.mY = 1;
                }
                if (direction == 4) //leftup
                {
                        this.mKey.mX = -.5;
                        this.mKey.mY = -.5;
                }
                if (direction == 5) //leftdown
                {
                        this.mKey.mX = -.5;
                      	this.mKey.mY = .5;
                }
                if (direction == 6) //rightup
                {
                        this.mKey.mX = .5;
                        this.mKey.mY = -.5;
                }
               	if (direction == 7) //rightdown
                {
                        this.mKey.mX = .5;
                        this.mKey.mY = .5;
                }
                if (direction == 8) //stop
                {
                        this.mKey.mX = 0;
               	        this.mKey.mY = 0;
                }
	} 

});

