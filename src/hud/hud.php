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
        northBoundsABCANDYOU = new Shape(120, y,  0,  0,"","","","red","boundary");
        northBoundsABCANDYOU.setText('ABCANDYOU');

        northBoundsUser = new Shape     (120, y,120,  0,"","","","orange","boundary");
        northBoundsUser.setText('User : ' + username);

        northBoundsMathLevel = new Shape(120, y,240,  0,"","","","yellow","boundary");
        northBoundsMathLevel.setText('Level : ' + next_level);

        northBoundsScore = new Shape    (120, y,360,  0,"","","","LawnGreen","boundary");
        northBoundsScore.setText('Score : ');

        northBoundsScoreNeeded = new Shape    (120, y,480,  0,"","","","cyan","boundary");
        northBoundsScoreNeeded.setText('Score Needed : ');

        northBoundsGameName = new Shape (170, y,600,  0,"","","","#DBCCE6","boundary");
        northBoundsGameName.setText('Choose Subject');

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


