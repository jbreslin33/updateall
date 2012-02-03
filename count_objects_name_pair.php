<?php

include("top.php");


include("middle.php");

?>

<!-- class for game -->
<?php include("game_count_objects_name_pair.php"); ?>

<!-- creating game --> 
<script type="text/javascript">  var game = new Game( <?php echo "$startNumber,$scoreNeeded,$countBy,$numberOfButtons);"; ?> </script>

<style>
	#draggable { width: 150px; height: 150px; padding: 0.5em; }
	</style>
	<script type="text/javascript">
	$(function() {
		$( "#draggable" ).draggable();
	});
	</script>



<div class="demo">

<div id="draggable" class="ui-widget-content">
	<p>Drag me around</p>
</div>

</div><!-- End demo -->



<div style="display: none;" class="demo-description">
<p>Enable draggable functionality on any DOM element. Move the draggable object by clicking on it with the mouse and dragging it anywhere within the viewport.</p>
</div><!-- End demo-description -->


<!-- lower.php -->
<?php include("lower.php"); ?>
