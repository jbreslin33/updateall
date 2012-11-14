var Dungeon = new Class(
{

Extends: Game,

	initialize: function()
	{
       		this.parent();

		//create key
		this.createKey("/images/key/key_dungeon.gif");
	
		//create door	
		this.createDoor("/images/doors/door_closed.png","/images/doors/door_open.png");
	},

	createKey: function(image_source)
	{
        	var keyQuestion = new Question('Pick up key.',"key");
        	mQuiz.mQuestionArray.push(keyQuestion);

        	openPoint = this.getOpenPoint2D(40,735,75,375,50,7);
        	var key = new Shape(50,50,openPoint.mX,openPoint.mY,this,keyQuestion,"/images/key/key_dungeon.gif","","key");
        	key.setVisibility(false);
        	key.mShowOnlyOnQuizComplete = true;
        	this.addToShapeArray(key);
	},

	createDoor: function(image_source_closed,image_source_open)
	{
        	var doorQuestion = new Question('Open door with key.',"door");
        	mQuiz.mQuestionArray.push(doorQuestion);

        	var openPoint = this.getOpenPoint2D(40,735,75,375,50,7);
        	var door = new ShapeDoor(50,50,openPoint.mX,openPoint.mY,this,doorQuestion,image_source_closed,"","door",image_source_open);
        	door.mUrl = '/src/database/goto_next_level.php';
        	door.mOpenOnQuestionSolved = true;
        	this.addToShapeArray(door);

	}
});

