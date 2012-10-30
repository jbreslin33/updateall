        //QUESTION SHAPES
        count = 0;
        for (i = 0; i < numberOfRows; i++)
        {
                var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape;
                mGame.addToShapeArray(shape = new Shape(50,50,openPoint.mX,openPoint.mY,mGame,mQuiz.getSpecificQuestion(count),"/images/treasure/gold_coin_head.png","","question"));
                shape.createMountPoint(0,-5,-41);
                shape.showQuestion(false);

                //numberMount to go on top let's make it small and draw it on top
                var questionMountee = new Shape(1,1,100,100,mGame,mQuiz.getSpecificQuestion(count),"","orange","questionMountee");
                questionMountee.setMountable(true);
                mGame.addToShapeArray(questionMountee);
                questionMountee.showQuestion(false);

                //do the mount
                shape.mount(questionMountee,0);

                questionMountee.setBackgroundColor("transparent");

                count++;
        }

