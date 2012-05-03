/***************************************
public methods
----------------

//get methods

//set methods
void set(x,y);

****************************************/

var Point2D = new Class(
{
        initialize: function(scoreNeeded)
        {
		//coordinates
		this.mX = 0;
		this.mY = 0;
        },

	set: function(x,y)
	{
        	//set coordinates 
                this.mX = x;
		this.mY = y;	
	}

});


