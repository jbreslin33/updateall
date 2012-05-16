var GameDungeon = new Class(
{

Extends: Game,

        initialize: function(name, leftBounds, rightBounds, topBounds, bottomBounds, numberOfChasers)
        {
                //application
                this.parent(name, leftBounds, rightBounds, topBounds, bottomBounds);

                //chasers
                this.mNumberOfChasers = numberOfChasers;
        },

        //update
        update: function()
        {
                this.parent();
          
		//door entered?
                this.checkForDoorEntered();
        },

	createWorld: function()
	{
                //create Shapes
                this.createShapes();
	},

	createShapes: function()
	{
		//control object
                this.mControlObject = new ShapeCenter("",50,50,100,100,"","blue","","controlObject",this);
		this.addToShapeArray(this.mControlObject);
		mApplication.log('chaser');	
                for (i = 0; i < this.mNumberOfChasers; i++)
                {
			var openPoint = this.getOpenPoint2D(50,4);
			this.addToShapeArray(new ShapeAI("",50,50,openPoint.mX,openPoint.mY,"","red","","chaser",this));
                }
	},

	resetGame: function()
	{
		//reset collidable to true
                for (i=0; i < this.mShapeArray.length; i++)
                {
                        //set every shape to spawn position
                        this.mShapeArray[i].mPosition.mX = this.mShapeArray[i].mPositionSpawn.mX;
                        this.mShapeArray[i].mPosition.mY = this.mShapeArray[i].mPositionSpawn.mY;
                        this.mShapeArray[i].setVisibility(true);
                }

                for (i=0; i < this.mShapeArray.length; i++)
		{
			if (this.mShapeArray[i].mCollidable == true)
			{
                		this.mShapeArray[i].mCollisionOn = true;
			}
		}

	},

	openTheDoors: function()
	{
 		//open the doors
                for (i=0; i < this.mShapeArray.length; i++)
                {
                	if (this.mShapeArray[i].mBackgroundColor == 'green')
                        {
                        	this.mShapeArray[i].setBackgroundColor('white');
                        }
                }
	},

        isEndOfGame: function()
        {
        
	},

        checkForDoorEntered: function()
        {
        
	},
	
	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);
		
		if (col1.mMessage == "controlObject" && col2.mMessage == "chaser")
                {
	                //feedback
                        this.setFeedback("Try again.");

                        //this deletes and then recreates everthing.
                        this.resetGame();
                }
 	}).protect()

});



