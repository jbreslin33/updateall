<?php

include("top.php");


include("middle.php");

?>

<!-- class for game -->
<?php include("game_count_objects_name_pair.php"); ?>

<!-- creating game --> 
<script type="text/javascript">  var game = new Game( <?php echo "$startNumber,$scoreNeeded,$countBy,$numberOfButtons);"; ?> </script>

<!-- drag stuff -->
<style>
	.ui-widget-content { width: 100px; height: 100px; padding: 0.5em; float: left; margin: 10px 10px 10px 0; }
	.ui-widget-header { width: 150px; height: 150px; padding: 0.5em; float: left; margin: 10px; }
	</style>
	<script>
	$(function() {
		$( ".ui-widget-content" ).draggable();
		$( ".ball_draggable" ).draggable();
		
		$( "#droppable" ).droppable({
			drop: function( event, ui ) {
				$( this )
					.addClass( "ui-state-highlight" )
					.find( "p" )
						.html( "Dropped!" );
			}
		});
	});
	</script>

<div class="demo">
	
<div id="draggable" class="ui-widget-content">
	<p>Drag me to my target</p>
</div>

<div id="droppable" class="ui-widget-header">
	<p>Drop here</p>
</div>

</div><!-- End demo -->

<div style="display: none;" class="demo-description">
<p>Enable any DOM element to be droppable, a target for draggable elements.</p>
</div><!-- End demo-description -->
<!-- end drag stuff -->

<!-- lower.php -->
<?php include("lower.php"); ?>
