<?php
$number_of_chasers = $_GET['chasers'];
echo "var chasers = $number_of_chasers;"; 
?>

for (i = 0; i < chasers; i++)
{
	var openPoint = mGame.getOpenPoint2D(40,735,75,375,50,7);
       	var shape = new ShapeChaser(50,50,openPoint.mX,openPoint.mY,mGame,"","/images/monster/red_monster.png","","chaser");
        mGame.addToShapeArray(shape);
} 
