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

                mGenre = new Genre(this, scoreNeeded, countBy, startNumber, endNumber, numberOfChasers, speed, leftBounds, rightBounds, topBounds, bottomBounds, collisionDistance);
                
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
                
                        //checkKeys
                        this.checkKeys();
                        
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

        checkKeys: function()
        {
                //left  
                if (this.mKeyLeft == true && this.mKeyRight == false && this.mKeyUp == false && this.mKeyDown == false)
                {
                        mGenre.mControlObject.mKeyX = -1;
                        mGenre.mControlObject.mKeyY = 0;
                }
        
                //right 
                if (this.mKeyLeft == false && this.mKeyRight == true && this.mKeyUp == false && this.mKeyDown == false)
                {
                        mGenre.mControlObject.mKeyX = 1;
                        mGenre.mControlObject.mKeyY = 0;
                }
        
                //up    
                if (this.mKeyLeft == false && this.mKeyRight == false && this.mKeyUp == true && this.mKeyDown == false)
                {
                        mGenre.mControlObject.mKeyX = 0;
                        mGenre.mControlObject.mKeyY = -1;
                }
                //down  
                if (this.mKeyLeft == false && this.mKeyRight == false && this.mKeyUp == false && this.mKeyDown == true)
                {
                        mGenre.mControlObject.mKeyX = 0;
                        mGenre.mControlObject.mKeyY = 1;
                }
                //left_up       
                if (this.mKeyLeft == true && this.mKeyRight == false && this.mKeyUp == true && this.mKeyDown == false)
                {
                        mGenre.mControlObject.mKeyX = -.5;
                        mGenre.mControlObject.mKeyY = -.5;
                }
                //left_down     
                if (this.mKeyLeft == true && this.mKeyRight == false && this.mKeyUp == false && this.mKeyDown == true)
                {
                        mGenre.mControlObject.mKeyX = -.5;
                        mGenre.mControlObject.mKeyY = .5;
                }
                //right_up      
                if (this.mKeyLeft == false && this.mKeyRight == true && this.mKeyUp == true && this.mKeyDown == false)
                {
                        mGenre.mControlObject.mKeyX = .5;
                        mGenre.mControlObject.mKeyY = -.5;
                }
                //right_down    
                if (this.mKeyLeft == false && this.mKeyRight == true && this.mKeyUp == false && this.mKeyDown == true)
                {
                        mGenre.mControlObject.mKeyX = .5;
                        mGenre.mControlObject.mKeyY = .5;
                }
                //all up...stop 
                if (this.mKeyLeft == false && this.mKeyRight == false && this.mKeyUp == false && this.mKeyDown == false)
                {
                        mGenre.mControlObject.mKeyX = 0;
                        mGenre.mControlObject.mKeyY = 0;
                }
        },

        //CONTROLS
        moveLeft: function()
        {
                //alert('moveLeft');
                mGenre.mControlObject.mKeyX = -1;
                mGenre.mControlObject.mKeyY = 0;
        },

        moveRight: function()
        {
                mGenre.mControlObject.mKeyX = 1;
                mGenre.mControlObject.mKeyY = 0;
        },

        moveUp: function()
        {
                mGenre.mControlObject.mKeyX = 0;
                mGenre.mControlObject.mKeyY = -1;
        },

        moveDown: function()
        {
                mGenre.mControlObject.mKeyX = 0;
                mGenre.mControlObject.mKeyY = 1;
        },

        moveStop: function()
        {
                mGenre.mControlObject.mKeyX = 0;
                mGenre.mControlObject.mKeyY = 0;
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


