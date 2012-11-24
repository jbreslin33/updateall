<?php

echo "<script language=\"javascript\">";
echo "var questions = new Array();";
echo "var answers = new Array();";
echo "</script>";



//*******************     anything in questions?
$query = "select question, answer, question_order from questions where level_id = ";
$query .= $_SESSION["next_level_id"];
$query .= " ORDER BY question_order;";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows which will also be score needed
$numberOfRowsInQuestions = pg_num_rows($result);


//*******************     anything in counting?
$query = "select score_needed, start_number, end_number, count_by from counting where level_id = ";
$query .= $_SESSION["next_level_id"];

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows which will also be score needed
$numberOfRowsInCounting = pg_num_rows($result);

if ($numberOfRowsInQuestions > 0)
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
	$numberOfRows = $numberOfRowsInQuestions;
} 

else if ($numberOfRowsInCounting > 0)
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
	$numberOfRows = $numberOfRowsInCounting;
}

echo "<script language=\"javascript\">";
echo "var numberOfRows = $numberOfRows;";
echo "var scoreNeeded = $numberOfRows;";
echo "</script>";



//could you just query counting then addition then multiplication then division etc using level and if there is something there use that?
//answer: no



?>
