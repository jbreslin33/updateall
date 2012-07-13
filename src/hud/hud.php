/***************************************
public methods
----------------

****************************************/

var Hud = new Class(
{
        initialize: function()
        {
	/******************* BOUNDARY WALLS AND HUD COMBO ***********/
        var ySize = 35;
        var yCoord = 35;
        this.mHome = new Shape(60, ySize,  0,  0,"","","","#F8CDF8","boundary");
        this.mHome.setText('<font size="1"> <a href="<?php getenv("DOCUMENT_ROOT")?>/web/home/home.php"> HOME</a> </font>');

	this.mLogout = new Shape     (60, ySize,60,  0,"","","","red","boundary");
        this.mLogout.setText('<font size="1"> <a href="<?php getenv("DOCUMENT_ROOT")?>/web/login/login_form.php"> LOGOUT</a> </font>');
	
	this.mUsername = new Shape     (120, ySize,120,  0,"","","","orange","boundary");
        this.mUsername.setText('<font size="2"> user : ' + username + '</font>');
        
	this.mLevel = new Shape(120, ySize,240,  0,"","","","yellow","boundary");
        this.mLevel.setText('<font size="2"> Level : ' + next_level + '</font>');

        this.mScore = new Shape    (120, ySize,360,  0,"","","","LawnGreen","boundary");
        this.mScore.setText('<font size="2"> Score : </font>');

        this.mScoreNeeded = new Shape    (120, ySize, 480,  0,"","","","cyan","boundary");

        this.mGameName = new Shape (170, ySize,600,  0,"","","","#F8CDF8","boundary");

        eastBounds  = new Shape         ( 10, 50,760, 35,"","","","#F8CDF8","boundary");
        eastBounds  = new Shape         ( 10, 50,760, 85,"","","","#F6C0F6","boundary");
        eastBounds  = new Shape         ( 10, 50,760,135,"","","","#F5B4F5","boundary");
        eastBounds  = new Shape         ( 10, 50,760,185,"","","","#F6C0F6","boundary");
        eastBounds  = new Shape         ( 10, 50,760,235,"","","","#F5B4F5","boundary");
        eastBounds  = new Shape         ( 10, 50,760,285,"","","","#F3A8F3","boundary");
        eastBounds  = new Shape         ( 10, 50,760,335,"","","","#F19BF1","boundary");
        eastBounds  = new Shape         ( 10, 20,760,385,"","","","#F08EF0","boundary");

        this.mQuestion = new Shape (770, ySize,  0,405,"","","","violet","boundary");

        westBounds  = new Shape         ( 10, 50,  0, 35,"","","","#F8CDF8","boundary");
        westBounds  = new Shape         ( 10, 50,  0, 85,"","","","#F6C0F6","boundary");
        westBounds  = new Shape         ( 10, 50,  0,135,"","","","#F5B4F5","boundary");
        westBounds  = new Shape         ( 10, 50,  0,185,"","","","#F6C0F6","boundary");
        westBounds  = new Shape         ( 10, 50,  0,235,"","","","#F5B4F5","boundary");
        westBounds  = new Shape         ( 10, 50,  0,285,"","","","#F3A8F3","boundary");
        westBounds  = new Shape         ( 10, 50,  0,335,"","","","#F19BF1","boundary");
        westBounds  = new Shape         ( 10, 20,  0,385,"","","","#F08EF0","boundary");

        }


});


