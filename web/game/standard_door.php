  	//question for door
        var doorQuestion = new Question('Open door with key.',"door");
        mQuiz.mQuestionArray.push(doorQuestion);

        //DOOR
        var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
        var door = new ShapeDoor(50,50,openPoint.mX,openPoint.mY,mGame,doorQuestion,"/images/doors/door_closed.png","","door","/images/doors/door_open.png");
        door.mUrl = '/src/database/goto_next_level.php';
        door.mOpenOnQuestionSolved = true;
        mGame.addToShapeArray(door);

