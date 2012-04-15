var GameDungeonCount = new Class(
{

Extends: Game,

        initialize: function(application, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance)
        {

                //application
                this.parent(application, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance);
         
        },

        //update
        update: function()
        {
                this.parent();
        },
	
	createWorld: function()
	{
                //create Shapes
                this.createShapes();

                //create walls
                this.createLeftWall();
                this.createRightWall();
                this.createTopWall();
                this.createBottomWall();

	},

	resetGame: function()
	{
              //set collidable to true
                for (i=0; i < this.mShapeArray.length; i++)
                {

                        //set every shape to spawn position
                        this.mShapeArray[i].mPositionX = this.mShapeArray[i].mSpawnPositionX;
                        this.mShapeArray[i].mPositionY = this.mShapeArray[i].mSpawnPositionY;

                        if (this.mShapeArray[i].mCollidable == true)
                        {
                                this.mShapeArray[i].mCollisionOn = true;
                                this.mShapeArray[i].setVisibility(true);
                        }
                }
                this.mControlObject.mPositionX = 0;
                this.mControlObject.mPositionY = 0;

                //score
                this.mQuiz.mScore = 0;

                //game
                this.mQuiz.mQuestion = this.mQuiz.mCount;

                //count
                this.mQuiz.mCount = this.mQuiz.mStartNumber;

                //answer
                this.mQuiz.newAnswer();
                this.mShapeArray[0].setText(this.mQuiz.mCount);

	}

});



