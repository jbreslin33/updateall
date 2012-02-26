<html>
<head>

<title>Image Mover</title>

<!-- jquery and jqueryui -->
<link type="text/css" href="jquery-ui-1.8.17.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="jquery-1.7.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>

<?php 
include("check_login.php");
include("db_connect.php");

//db connection
$conn = dbConnect();

//query
$query = "select name, score_needed, count_by, start_number, end_number, tick_length from math_games where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$name = "";
$scoreNeeded = 0;
$countBy = 0;
$startNumber = 0;
$endNumber = 0;
$tickLength = 0;

//get numer of rows
$num = pg_num_rows($result);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
        //get row
        $row = pg_fetch_row($result);

        //fill php vars from db
        $name = $row[0];
        $scoreNeeded = $row[1];
        $countBy = $row[2];
        $startNumber = $row[3];
        $endNumber = $row[4];
        $tickLength = $row[5];
}

?>



<script language="javascript">

//globals

//players
var mPlayerArray = new Array();
var mControlObject;

//score
var mScoreNeeded = 0;
var mScore = 0;

//count
var mCountBy = 0;
var mCount = 0;
var mStartNumber = 0;
var mEndNumber = 0;

//ticks
var mTickLength = 0;

//questions
var mQuestion = 0;
var mGuess = 0;
var mAnswer = 0;

// id counter
var mIdCount = 0;

function Game(scoreNeeded, countBy, startNumber, endNumber, tickLength)
{
	//players

        //score
        mScoreNeeded = scoreNeeded;

        //count
        mCountBy = countBy;
        mStartNumber = startNumber;
        mEndNumber = endNumber; 

        //ticks
        mTickLength = tickLength;


}

function init()
{
	//create game	
	var game = new Game( <?php echo "$scoreNeeded, $countBy, $startNumber, $endNumber, $tickLength);"; ?>
	
	//create all players
	createPlayer('smiley.png',300,300,true);
	createPlayer('1.png',75,75,false);
	createPlayer('2.png',75,150,false);
	createPlayer('3.png',300,450,false);
	createPlayer('4.png',0,150,false);
	createPlayer('5.png',0,300,false);
	createPlayer('6.png',150,150,false);
	createPlayer('7.png',300,0,false);
	createPlayer('8.png',150,0,false);
	createPlayer('9.png',450,150,false);
	createPlayer('10.png',75,300,false);

	//start update
	update();
}

function update()
{	
	//move players	
	movePlayers();

	//check bounds
        //checkBounds(document.getElementById("redball1"));     

	//check collisions
        //checkCollisions();
		
	//graphics	
	render();
       
	//tick 
	window.setTimeout('update()',mTickLength);
}

function createPlayer(src,spawnX,spawnY,isControlObject)
{
	
	//create the movable div that will be used to move image around.	
	var div = document.createElement('div');
        div.setAttribute('id','div' + mIdCount);
        div.setAttribute("class","movable");
	div.style.position="absolute";
        document.body.appendChild(div);

	//image to attache to our div "vessel"
        var image = document.createElement("IMG");
        image.id = 'image' + mIdCount;
        image.alt = 'image' + mIdCount;
        image.title = 'image' + mIdCount;   
        div.appendChild(image);
        
	image.src  = src;

        div.mPositionX = spawnX;
        div.mPositionY = spawnY;

        div.mVelocityX = 0;
        div.mVelocityY = 0;

        div.mCollidable = true;
	
	if (isControlObject)
	{
		mControlObject = div;
	}
	
	//move it
        div.style.left = spawnX+'px';
        div.style.top  = spawnY+'px';

	//add to array
	mPlayerArray.push(div);

	//increment uniqueid count	
	mIdCount++;
}


function movePlayers()
{
        //move numbers
        for (i=0; i<mPlayerArray.length; i++)
        {
                div = mPlayerArray[i];
		 
		div.mPositionX += div.mVelocityX;
                div.mPositionY += div.mVelocityY;
        }
}

//this renders avatar in center of viewport then draws everthing else in relation to avatar
function render()
{
        //loop thru player array and update their xy positions
        for (i=0; i<mPlayerArray.length; i++)
        {
		//get the center of the page xy
       		var pageCenterX = $(this).width() / 2;
        	var pageCenterY = $(this).height() / 2;
      
       		//get the center xy of the image
       		var imageCenterX = $("#image" + i).width() / 2;     
       		var imageCenterY = $("#image" + i).height() / 2;     

		//if control object center it on screen
		if (mPlayerArray[i] == mControlObject)
		{
			//shift the position based on pageCenterXY and imageCenterXY	
        		var posX = pageCenterX - imageCenterX;     
        		var posY = pageCenterY - imageCenterY;     
			
			//this actual moves it  
        		mPlayerArray[i].style.left = posX+'px';
        		mPlayerArray[i].style.top  = posY+'px';
		} 
		//else if anything else render relative to the control object	
		else
		{
			//get the offset from control object
			var xdiff = mPlayerArray[i].mPositionX - mControlObject.mPositionX;  
                	var ydiff = mPlayerArray[i].mPositionY - mControlObject.mPositionY;  

                	//center image relative to position
                	var posX = xdiff + pageCenterX - imageCenterX;
                	var posY = ydiff + pageCenterY - imageCenterY;    
               
			//if off screen then hide it so we don't have scroll bars mucking up controls 
                	if (posX + $("#image" + i).width() > $(this).width() || posY + $("#image" + i).height() > $(this).height())
                	{
                        	mPlayerArray[i].style.visibility = 'hidden';
                        	mPlayerArray[i].style.left = 0+'px';
                        	mPlayerArray[i].style.top  = 0+'px';
                	}
			//else make sure it's visible
                	else
                	{
                        	mPlayerArray[i].style.visibility = 'visible';
                        	mPlayerArray[i].style.left = posX+'px';
                        	mPlayerArray[i].style.top  = posY+'px';
               		} 
		}
        }
}

function moveLeft()
{
        mControlObject.mVelocityX = -1;
        mControlObject.mVelocityY = 0;
}

function moveRight()
{
        mControlObject.mVelocityX = 1;
        mControlObject.mVelocityY = 0;
}

function moveUp()
{
        mControlObject.mVelocityX = 0;
        mControlObject.mVelocityY = -1;
}

function moveDown()
{
        mControlObject.mVelocityX = 0;
        mControlObject.mVelocityY = 1;
}

function moveStop()
{
        mControlObject.mVelocityX = 0;
        mControlObject.mVelocityY = 0;
}

document.onkeydown = function(ev) 
{
        var keynum;
        ev = ev || event;
        keynum = ev.keyCode;

        if (keynum == 37)
        {
                moveLeft();  
        }       
        if (keynum == 39)
        {
                moveRight(); 
        }       
        if (keynum == 38)
        {
                moveUp();    
        }       
        if (keynum == 40)
        {
                moveDown();  
        }       
        if (keynum == 32)
        {
                moveStop();  
        }       
}

</script>

</head>

<script type="text/javascript"> 

$(document).ready(function()
{
        init();
}
);

</script>

</body>
</html>
