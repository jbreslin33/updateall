<html>
<head>
<title>Image Mover</title>
<style>
DIV.movable { position:absolute; }
</style>
<script language="javascript">
var x = 5; //Starting Location - left
var y = 5; //Starting Location - top
var interval = 1; //Move 10px every initialization


function game()
{

}

function createPlayer()
{
	//create the movable div that will be used to move image around.	
	//var newdiv = document.createElement('div');
        //newdiv.setAttribute('id','redball1');
        //newdiv.setAttribute("class","movable");
        //document.body.appendChild(newdiv);

	//image to attache to our div "vessel"
        var img = document.createElement("IMG");
        img.id = 'avatar';
        img.alt = 'avatart';
        img.title = 'avatar';   
        document.getElementById('redball1').appendChild(img);
        document.getElementById('avatar').src  = "redball.png";

        document.getElementById("redball1").mPositionX = 0;
        document.getElementById("redball1").mPositionY = 0;

        document.getElementById("redball1").mVelocityX = 0;
        document.getElementById("redball1").mVelocityY = 0;

        document.getElementById("redball1").mCollidable = true;

	//move it
        document.getElementById("redball1").style.left = 200+'px';
        document.getElementById("redball1").style.top  = 200+'px';

	

}

</script>
</head>
<body onload="createPlayer()">

<div id="redball1" class="movable">
<alt="Please link to a vaild image." /> 
</div>

<!-- create images 
<style>
DIV.movable { position:absolute; }
</style>
-->

</body>
</html>
