var Application = new Class(
{
        initialize: function(tickLength)
        {
                //window size
                this.mWindow = window.getSize();

                //ticks
                this.mTickLength = tickLength;
                
                //time
                this.mTimeSinceEpoch = 0;
                this.mLastTimeSinceEpoch = 0;
                this.mTimeSinceLastInterval = 0;
                
                //key pressed
                this.mKeyLeft = false;
                this.mKeyRight = false;
                this.mKeyUp = false;
                this.mKeyDown = false;
                this.mKeyStop = false;

                mGenre = new GenreAdventure(this, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance);
                
                //this will be used for resetting to
                mGenre.resetGame();

                g = new Date();
        },

        update: function()
        {
                if (mGenre.mGenreOn)
                {
                        //get time since epoch and set lasttime 
                        e = new Date();
                        this.mLastTimeSinceEpoch = this.mTimeSinceEpoch;
                        this.mTimeSinceEpoch = e.getTime();
                
                        //set timeSinceLastInterval as function of timeSinceEpoch and LastTimeSinceEpoch diff
                        this.mTimeSinceLastInterval = this.mTimeSinceEpoch - this.mLastTimeSinceEpoch;
                
                        //old update only
                        mGenre.update(); 
                
                        //render();     
                        
                        var t=setTimeout("mApplication.update()",20)
                }
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


