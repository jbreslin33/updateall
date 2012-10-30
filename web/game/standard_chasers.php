 	//CHASERS
        chasers = 0;
        for (i = 0; i < chasers; i++)
        {
                var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
                var shape = new ShapeChaser(50,50,openPoint.mX,openPoint.mY,mGame,"","/images/monster/red_monster.png","","chaser");
                mGame.addToShapeArray(shape);
        }

