var GameDungeonCount = new Class(
{

Extends: Game,

        initialize: function(name, leftBounds, rightBounds, topBounds, bottomBounds, numberOfChasers, scoreNeeded, countBy, startNumber, endNumber)
        {

                //application
                this.parent(name, leftBounds, rightBounds, topBounds, bottomBounds);

                //chasers
                this.mNumberOfChasers = numberOfChasers;

		//the quiz
        	this.mQuiz = new QuizCount(scoreNeeded,countBy,startNumber,endNumber);

        },

        //update
        update: function()
        {
                this.parent();
          
		//door entered?
                this.checkForDoorEntered();

        },

 	getOpenPoint2D: (function(newShapeWidth,spreadFactor)
        {
		while (true)
		{
                       	//let's get a random open space...
                       	//get the size of the playing field
                       	var xSize = this.mRightBounds - this.mLeftBounds;
                       	var ySize = this.mBottomBounds - this.mTopBounds;

                       	//get point that would fall in the size range from above
                        var randomPoint2D = new Point2D( Math.floor( Math.random()*xSize) , Math.floor(Math.random()*ySize));

                        //now add the left and top bounds so that it is on the games actual field
                        randomPoint2D.mX += this.mLeftBounds;
                        randomPoint2D.mY += this.mTopBounds;
		
			//we now need to see if we can make it thru all shapes without a collision
			var isCollision = false;	
			for (s = 0; s < this.mShapeArray.length; s++)
                	{
                        	if (this.mShapeArray[s].mCollidable ==  true)
                        	{
                                	var x1 = this.mShapeArray[s].mPosition.mX;
                                	var y1 = this.mShapeArray[s].mPosition.mY;
 
                                	var x2 = randomPoint2D.mX;              
                                	var y2 = randomPoint2D.mY;              
                
                                	var distSQ = Math.pow(x1-x2,2) + Math.pow(y1-y2,2);
					var collisionDistanceOfNewShape = newShapeWidth * 6.5;
                                	var collisionDistance = (this.mShapeArray[s].mCollisionDistance + collisionDistanceOfNewShape) * spreadFactor;
                                                
                                	if (distSQ < collisionDistance) 
                                	{
                               			isCollision = true; 
					}
                        	}
                	}
			
			//we have an open point	
			if (isCollision == false)
			{
				return randomPoint2D;
			}
      		} 
 
        }).protect(),

	
	createWorld: function()
	{

                //create walls
                this.createLeftWall();
                this.createRightWall();
                this.createTopWall();
                this.createBottomWall();

                //create Shapes
                this.createShapes();
		
		//create quiz shapes
 		for (i = this.mQuiz.mStartNumber + this.mQuiz.mCountBy; i <= this.mQuiz.mEndNumber; i = i + this.mQuiz.mCountBy)
                {
			var openPoint = this.getOpenPoint2D(50,2);
		  	this.addToShapeArray(new ShapeRelative("",50,50,openPoint.mX,openPoint.mY,i,"yellow","","question",this));
                }
	},

	createShapes: function()
	{
		//control object
                this.mControlObject = new ShapeCenter("",50,50,100,100,"","blue","","controlObject",this);
		this.addToShapeArray(this.mControlObject);
	
                for (i = 0; i < this.mNumberOfChasers; i++)
                {
			var openPoint = this.getOpenPoint2D(50,2);
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


		//let's reset all quiz stuff right here.
		this.mQuiz.reset();

		//set text of control object
		this.mControlObject.setText(this.mQuiz.getQuestion());

	},

   	createLeftWall: function()
        {
                for (i = this.mTopBounds + 50; i <= this.mBottomBounds - 50; i = i + 50)
                {
                        this.addToShapeArray(new ShapeRelative("",50,50,this.mLeftBounds,i,"","black","","wall",this));
                }
        },

        createRightWall: function()
        {
                var greenDoorCount = 0; 
                for (i = this.mTopBounds; i <= this.mBottomBounds; i = i + 50)
                {
                        if (greenDoorCount == 0 || greenDoorCount == 1)
                        {
                                this.addToShapeArray(new ShapeRelative("",50,50,this.mRightBounds,i,"","green","","wall",this));
                        }       
                        else
                        {       
                                this.addToShapeArray(new ShapeRelative("",50,50,this.mRightBounds,i,"","black","","wall",this));
                        }
                        greenDoorCount++;
                }
        
        },

        createTopWall: function()
        {
                for (i = this.mLeftBounds + 50; i <= this.mRightBounds - 50; i = i + 50)
                {
                        this.addToShapeArray(new ShapeRelative("",50,50,i,this.mTopBounds,"","black","","wall",this));
                }
        },

        createBottomWall: function()
        {
                for (i = this.mLeftBounds + 50; i <= this.mRightBounds - 50; i = i + 50)
                {
                        this.addToShapeArray(new ShapeRelative("",50,50,i,this.mBottomBounds,"","black","","wall",this));
                }
        },

        checkForScoreNeeded: function()
        {
                if (this.mQuiz.getScore() == this.mQuiz.getScoreNeeded())
                {
                        //open the doors
                        for (i=0; i < this.mShapeArray.length; i++)
                        {
                                if (this.mShapeArray[i].mBackgroundColor == 'green')
                                {
                                        this.mShapeArray[i].setBackgroundColor('white');
                                }
                        }
                }
        },

        checkForDoorEntered: function()
        {
                if (this.mQuiz.getScore() == this.mQuiz.getScoreNeeded())
                {
                        if (this.mControlObject.mPosition.mX > this.mRightBounds - 50 / 2 &&
                        this.mControlObject.mPosition.mY > this.mTopBounds &&
                        this.mControlObject.mPosition.mY < this.mTopBounds + 50 * 2)

                        {
                                this.mOn = false;
				this.setFeedback("YOU WIN!!!");
                                window.location = "../database/goto_next_math_level.php"
                        }
                }
        },
	
	evaluateCollision: (function(col1,col2)
        {
	        this.parent(col1,col2);
		
		if (col1.mMessage == "controlObject" && col2.mMessage == "question")
		{
                        if (this.mQuiz.submitAnswer(col2.mInnerHTML))
                        {
                                col2.mCollisionOn = false;
                                col2.setVisibility(false);

                                //feedback
                                this.setFeedback("Correct!");

                                //get a new question
                                this.mQuiz.newQuestion();

                                //set text of control object
                                col1.setText(this.mQuiz.mCount);
                        }
                        else
                        {
                                //feedback
                                this.setFeedback("Try again.");

                                //this deletes and then recreates everthing.
                                this.resetGame();
                        }
                }

		if (col1.mMessage == "controlObject" && col2.mMessage == "chaser")
                {
	                //feedback
                        this.setFeedback("Try again.");

                        //this deletes and then recreates everthing.
                        this.resetGame();
                }
 	}).protect()

});



