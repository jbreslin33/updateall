/******************************************************************** 

Application Class: This class handles Time, ticks and keystrokes. and is ex-
tended to create different games.

********************************************************************/
 
var Application = new Class(
{
        initialize: function()
        {
                //window size
                this.mWindow = window.getSize();

                //key pressed
                this.mKeyLeft = false;
                this.mKeyRight = false;
                this.mKeyUp = false;
                this.mKeyDown = false;
                this.mKeyStop = false;
		this.mKeySpace = false;
		this.mKey0 = false;
		this.mKey1 = false;
		this.mKey2 = false;
		this.mKey3 = false;
		this.mKey4 = false;
		this.mKey5 = false;
		this.mKey6 = false;
		this.mKey7 = false;
		this.mKey8 = false;
		this.mKey9 = false;

		//mouse
		this.mMouseDown = false;
		this.mMouseUp   = true;
		this.mMouseX = 0;
		this.mMouseY = 0;

        },

        log: function(msg)
        {
                setTimeout(function()
                {
                        throw new Error(msg);
                }, 0);
        },



        //CONTROLS
        
	mouseDown: function(event)
	{
		mApplication.log('mouse down!');
		mApplication.log('page.x:' + event.page.x);

	},	


	keyDown: function(event)
        {
                if (event.key == 'left')
                {
                        mApplication.mKeyLeft = true;
                }
                if (event.key == 'right')
                {
                        mApplication.mKeyRight = true;
                }
                if (event.key == 'up')
                {
                        mApplication.mKeyUp = true;
                }
                if (event.key == 'down')
                {
                        mApplication.mKeyDown = true;
                }
                if (event.key == 'space')
                {
                        mApplication.mKeySpace = true;
                }
		if (event.key == '0')
                {
                        mApplication.mKey0 = true;
                }
                if (event.key == '1')
                {
                        mApplication.mKey1 = true;
                }
                if (event.key == '2')
                {
                        mApplication.mKey2 = true;
                }
                if (event.key == '3')
                {
                        mApplication.mKey3 = true;
                }
                if (event.key == '4')
                {
                        mApplication.mKey4 = true;
                }
                if (event.key == '5')
                {
                        mApplication.mKey5 = true;
                }
                if (event.key == '6')
                {
                        mApplication.mKey6 = true;
                }
                if (event.key == '7')
                {
                        mApplication.mKey7 = true;
                }
                if (event.key == '8')
                {
                        mApplication.mKey8 = true;
                }
                if (event.key == '9')
                {
                        mApplication.mKey9 = true;
               	} 
        },
        
        keyUp: function(event)
        {       
                if (event.key == 'left')
                {
                        mApplication.mKeyLeft = false;
                }
                if (event.key == 'right')
                {
                        mApplication.mKeyRight = false;
                }
                if (event.key == 'up')
                {
                        mApplication.mKeyUp = false;
                }
                if (event.key == 'down')
                {
                        mApplication.mKeyDown = false;
                }
                if (event.key == 'space')
                {
                        mApplication.mKeySpace = false;
                }
                if (event.key == '0')
                {
                        mApplication.mKey0 = false;
                }
                if (event.key == '1')
                {
                        mApplication.mKey1 = false;
                }
                if (event.key == '2')
                {
                        mApplication.mKey2 = false;
                }
                if (event.key == '3')
                {
                        mApplication.mKey3 = false;
                }
                if (event.key == '4')
                {
                        mApplication.mKey4 = false;
                }
                if (event.key == '5')
                {
                        mApplication.mKey5 = false;
                }
                if (event.key == '6')
                {
                        mApplication.mKey6 = false;
                }
                if (event.key == '7')
                {
                        mApplication.mKey7 = false;
                }
                if (event.key == '8')
                {
                        mApplication.mKey8 = false;
                }
                if (event.key == '9')
                {
                        mApplication.mKey9 = false;
                }
        }
});



