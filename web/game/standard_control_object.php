    	//CONTROL OBJECT
        mGame.mControlObject = new Player(50,50,400,300,mGame,mQuiz.getSpecificQuestion(0),"/images/characters/wizard.png","","controlObject");
        mGame.mControlObject.mHideOnQuestionSolved = false;
        mGame.mControlObject.createMountPoint(0,-5,-41);

        //set animation instance
        mGame.mControlObject.mAnimation = new AnimationAdvanced(mGame.mControlObject);

        mGame.mControlObject.mAnimation.addAnimations('/images/characters/wizard_','.png');

        mGame.addToShapeArray(mGame.mControlObject);
        mGame.mControlObject.showQuestionObject(false);

        //text question mountee
        var questionMountee = new Shape(100,50,300,300,mGame,mQuiz.getSpecificQuestion(0),"","orange","questionMountee");
        questionMountee.setMountable(true);
        questionMountee.setHideOnDrop(true);
        mGame.addToShapeArray(questionMountee);
        mGame.mControlObject.setStartingMountee(questionMountee);

        //do the mount
        mGame.mControlObject.mount(questionMountee,0);

        questionMountee.setBackgroundColor("transparent");
        questionMountee.showQuestion(true);

