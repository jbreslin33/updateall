<html>
<body>

<style>

DIV.movable { position:absolute; }

</style>

<input type="text" id="clock" />

<div id="wizard" class="movable"><img src="wizard_north.png" /></div>

<script language=javascript>

var int=self.setInterval("clock()",1000);

document.getElementById("wizard").style.top  = '200px';
document.getElementById("wizard").style.left = '0px';

function clock()
{
	var d=new Date();
  	var t=d.toLocaleTimeString();
  	document.getElementById("clock").value=t;

	//move wizard
	document.getElementById("wizard").style.top  = '200px';
	document.getElementById("wizard").style.left = '0px';
}



</script>

<button onclick="int=window.clearInterval(int)">Stop</button>

</body>
</html> 
