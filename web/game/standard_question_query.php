<?php

echo "<script language=\"javascript\">";
echo "var questions = new Array();";
echo "var answers = new Array();";
echo "</script>";

//query the game table, eventually maybe there will be more than one result here which would be a choice of game for that level.
$query = "select question, answer, question_order from questions where level_id = ";
$query .= $_SESSION["next_level_id"];
$query .= " ORDER BY question_order;";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows which will also be score needed
$numberOfRows = pg_num_rows($result);

if ($numberOfRows > 0)
{
	$counter = 0;
	while ($row = pg_fetch_row($result))
	{
        	//fill php vars from db
        	$questions = $row[0];
        	$answers = $row[1];

        	echo "<script language=\"javascript\">";

        	echo "questions[$counter] = \"$questions\";";
        	echo "answers[$counter] = \"$answers\";";
        	echo "</script>";
        	$counter++;
	}
}


echo "<script language=\"javascript\">";
echo "var numberOfRows = $numberOfRows;";
echo "var scoreNeeded = $numberOfRows;";
echo "</script>";



//could you just query counting then addition then multiplication then division etc using level and if there is something there use that?
//answer: no



?>
