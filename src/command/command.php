/***************************************
public methods
----------------

//get methods

//set methods
void set(x,y);

****************************************/

var Command = new Class(
{
        initialize: function()
        {
		this.mDirection = new Point2D();
		this.mSpace     = false;
        },

	set: function(point2D,space)
	{
        	//set coordinates 
		this.mDirection.mX = point2D.mX;
		this.mDirection.mY = point2D.mY;

		this.mSpace = space;
	}

});


