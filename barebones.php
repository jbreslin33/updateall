<html>
<!-- jquery and jqueryui -->
<link type="text/css" href="jquery-ui-1.8.17.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="jquery-1.7.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>

<head>
<title>Image Mover</title>
<style>
DIV.movable { position:absolute; }
</style>

</head>


<script language="javascript">

	var mViewPortX = 0;
	var mViewPortY = 0;
	var mStartNumber = 1;
	var mEndNumber = 10;
	var mTickLength = 16;
	var mSpriteX = 50;
	var mSpriteY = 50;
	var mCount = 0;	
	
	//ball positions
	var mNumberPositionXArray = new Array(+000,-375,+300,-225,-150,-075,+075,+150,+225,-300,+375);
	var mNumberPositionYArray = new Array(+000,+000,+300,-200,+225,-300,+075,-375,+150,+075,+000);	
	

function createImages()
{
	//avatar
	var newdiv = document.createElement('div');
	newdiv.setAttribute('id','redball1');
	newdiv.setAttribute("class","movable");
	document.body.appendChild(newdiv);

	var img = document.createElement("IMG");
	img.id = 'avatar';
	document.getElementById('redball1').appendChild(img);
	document.getElementById('avatar').src  = "redball.png";

	document.getElementById("redball1").mPositionX = 0;
       	document.getElementById("redball1").mPositionY = 0;

	document.getElementById("redball1").mVelocityX = 0;
       	document.getElementById("redball1").mVelocityY = 0;

	document.getElementById("redball1").mCollidable = true;

	//numbers	
	var i = 0;
	for (i=mStartNumber;i<=mEndNumber;i++)
	{
		//create the images
		var newdiv = document.createElement('div'); 
		newdiv.setAttribute('id','number' + i); 	
		newdiv.setAttribute("class","movable"); 
		document.body.appendChild(newdiv); 	
	
		var img = document.createElement("IMG");
		img.id = 'image' + i;	
		document.getElementById('number' + i).appendChild(img);
	
		document.getElementById('image' + i).src  = i + ".png";
		
                document.getElementById('number' + i).mPositionX = mNumberPositionXArray[i];
                document.getElementById('number' + i).mPositionY = mNumberPositionYArray[i];

		document.getElementById('number' + i).mVelocityX = 0;
        	document.getElementById('number' + i).mVelocityY = 0;
		
        	document.getElementById('number' + i).mCollidable = true;
		document.getElementById('number' + i).mID = i;
		document.getElementById('number' + i).mAnswer = i;
	}  
	move();
}
//this renders avatar in center of viewport then draws everthing else in relation to avatar
function render()
{
	//viewport
	mViewPortX = $(this).width();
        mViewPortY = $(this).height();
	
	var xCenter = mViewPortX / 2;
	var yCenter = mViewPortY / 2;
	
	var x = 0;
	var y = 0; 
	
	//this centers avatar in view port
	x = xCenter - mSpriteX / 2; 	
	y = yCenter - mSpriteY / 2; 	
	
	//this actual moves it	
	document.getElementById("redball1").style.left = x+'px';
        document.getElementById("redball1").style.top  = y+'px';

	//move numbers
	for (i=mCount + 1;i<=mEndNumber;i++)
	{
		var xdiff = document.getElementById('number' + i).mPositionX - document.getElementById("redball1").mPositionX;	
		var ydiff = document.getElementById('number' + i).mPositionY - document.getElementById("redball1").mPositionY;	

		//center image
		x = xdiff + xCenter;
		y = ydiff + yCenter;	
		x = x - mSpriteX / 2;	
		y = y - mSpriteY / 2;	
		
		if (x + mSpriteX > mViewPortX || y + mSpriteY > mViewPortY)
		{
			document.getElementById('image' + i).style.visibility = 'hidden';
			document.getElementById('number' + i).style.left = 0+'px';
       			document.getElementById('number' + i).style.top  = 0+'px';
		}
		else
		{
			document.getElementById('image' + i).style.visibility = 'visible';
			document.getElementById('number' + i).style.left = x+'px';
       			document.getElementById('number' + i).style.top  = y+'px';
		}
	}
}

function move()
{
	render();

        window.setTimeout('move()',mTickLength);
}

</script>
<body onload="createImages()">


</div>

</body>
</html>
