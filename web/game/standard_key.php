        //question for key
        var keyQuestion = new Question('Pick up key.',"key");
        mQuiz.mQuestionArray.push(keyQuestion);

        //KEY
        openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
        var key = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,keyQuestion,"/images/key/key_dungeon.gif","","key");
        key.setVisibility(false);
        key.mShowOnlyOnQuizComplete = true;
        key.mMountable = true;
        key.setHideOnQuestionSolved(false);
        mGame.addToShapeArray(key);

