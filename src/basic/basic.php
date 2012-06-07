<html>
<body>

<style>

DIV.movable { position:absolute; }

</style>

<input type="text" id="clock" />

<div id="wizard" class="movable"><img src="wizard_north.png" /></div>

<script language=javascript>

var int=self.setInterval("clock()",1000);


x = 0; 
y = 200;

document.getElementById("wizard").style.left = x + 'px';
document.getElementById("wizard").style.top  = y + 'px';



function clock()
{
//	var d=new Date();
 // 	var t=d.toLocaleTimeString();
  //	document.getElementById("clock").value=t;
	
	//move wizard
	x++;
	document.getElementById("wizard").style.left = x + 'px';
	document.getElementById("wizard").style.top  = y + 'px';
}



</script>

<button onclick="int=window.clearInterval(int)">Stop</button>

</body>
</html> 
