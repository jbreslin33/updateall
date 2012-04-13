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


        },

        log: function(msg)
        {
                setTimeout(function()
                {
                        throw new Error(msg);
                }, 0);
        },

        //CONTROLS
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
        }
});



