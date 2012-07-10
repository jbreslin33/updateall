/***************************************
public methods
----------------

****************************************/

var Hud = new Class(
{
        initialize: function()
        {
	/******************* BOUNDARY WALLS AND HUD COMBO ***********/
        var y = 35;
        linksMain = new Shape(60, y,  0,  0,"","","","#F8CDF8","boundary");
        linksMain.setText('<font size="1"> <a href = "../home/home.php"> HOME</a> </font>');
        
	linksLogout = new Shape     (60, y,60,  0,"","","","red","boundary");
        linksLogout.setText('<font size="1"> <a href = "../../login/login_form.php"> LOGOUT</a> </font>');
	
	northBoundsUser = new Shape     (120, y,120,  0,"","","","orange","boundary");
        northBoundsUser.setText('<font size="2"> User : ' + username + '</font>');
        
	northBoundsMathLevel = new Shape(120, y,240,  0,"","","","yellow","boundary");
        northBoundsMathLevel.setText('<font size="2"> Level : ' + next_level + '</font>');

        northBoundsScore = new Shape    (120, y,360,  0,"","","","LawnGreen","boundary");
        northBoundsScore.setText('<font size="2"> Score : </font>');

        northBoundsScoreNeeded = new Shape    (120, y,480,  0,"","","","cyan","boundary");

        northBoundsGameName = new Shape (170, y,600,  0,"","","","#F8CDF8","boundary");

        eastBounds  = new Shape         ( 10, 50,760, 35,"","","","#F8CDF8","boundary");
        eastBounds  = new Shape         ( 10, 50,760, 85,"","","","#F6C0F6","boundary");
        eastBounds  = new Shape         ( 10, 50,760,135,"","","","#F5B4F5","boundary");
        eastBounds  = new Shape         ( 10, 50,760,185,"","","","#F6C0F6","boundary");
        eastBounds  = new Shape         ( 10, 50,760,235,"","","","#F5B4F5","boundary");
        eastBounds  = new Shape         ( 10, 50,760,285,"","","","#F3A8F3","boundary");
        eastBounds  = new Shape         ( 10, 50,760,335,"","","","#F19BF1","boundary");
        eastBounds  = new Shape         ( 10, 20,760,385,"","","","#F08EF0","boundary");

        southBoundsQuestion = new Shape (770, y,  0,405,"","","","violet","boundary");

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


