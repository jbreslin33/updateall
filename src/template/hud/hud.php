 /******************* BOUNDARY WALLS AND HUD COMBO ***********/
        var y = 35;
        mHudTitle = new Shape(120, y,  0,  0,"","","","red","boundary");
        mHudTitle.setText('ABCANDYOU');

        mHudUser = new Shape     (120, y,120,  0,"","","","orange","boundary");
        mHudUser.setText('User : ' + username);

        mHudLevel = new Shape(120, y,240,  0,"","","","yellow","boundary");
        mHudLevel.setText('Level : ');

        mHudScore = new Shape    (120, y,360,  0,"","","","LawnGreen","boundary");
        mHudScore.setText('Score : ');

        mHudScoreNeeded = new Shape    (120, y,480,  0,"","","","cyan","boundary");
        mHudScoreNeeded.setText('Score Needed : ');

        mHudGameName = new Shape (170, y,600,  0,"","","","#DBCCE6","boundary");
        mHudGameName.setText('Choose Subject');

        new Shape         ( 10, 50,760, 35,"","","","#F8CDF8","boundary");
        new Shape         ( 10, 50,760, 85,"","","","#F6C0F6","boundary");
        new Shape         ( 10, 50,760,135,"","","","#F5B4F5","boundary");
        new Shape         ( 10, 50,760,185,"","","","#F6C0F6","boundary");
        new Shape         ( 10, 50,760,235,"","","","#F5B4F5","boundary");
        new Shape         ( 10, 50,760,285,"","","","#F3A8F3","boundary");
        new Shape         ( 10, 50,760,335,"","","","#F19BF1","boundary");
        new Shape         ( 10, 20,760,385,"","","","#F08EF0","boundary");

        mHudQuestion = new Shape (770, y,  0,405,"","","","violet","boundary");

        new Shape         ( 10, 50,  0, 35,"","","","#F8CDF8","boundary");
        new Shape         ( 10, 50,  0, 85,"","","","#F6C0F6","boundary");
        new Shape         ( 10, 50,  0,135,"","","","#F5B4F5","boundary");
        new Shape         ( 10, 50,  0,185,"","","","#F6C0F6","boundary");
        new Shape         ( 10, 50,  0,235,"","","","#F5B4F5","boundary");
        new Shape         ( 10, 50,  0,285,"","","","#F3A8F3","boundary");
        new Shape         ( 10, 50,  0,335,"","","","#F19BF1","boundary");
        new Shape         ( 10, 20,  0,385,"","","","#F08EF0","boundary");

