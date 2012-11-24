<?php

echo "<script language=\"javascript\">";
echo "var questions = new Array();";
echo "var answers = new Array();";
echo "var scoreNeeded = 0;";
echo "var numberOfRows = 0;";
echo "</script>";



//*******************     anything in questions? *******************************
$query = "select question, answer, question_order from questions where level_id = ";
$query .= $_SESSION["next_level_id"];
$query .= " ORDER BY question_order;";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows which will also be score needed
$numberOfRowsInQuestions = pg_num_rows($result);


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

	echo "<script language=\"javascript\">";
	echo "scoreNeeded = $numberOfRows;";
	echo "numberOfRows = $numberOfRows;";
	echo "</script>";
} 

//*******************     anything in counting? if so override above ^ **********************************
$query = "select score_needed, start_number, end_number, count_by from counting where level_id = ";
$query .= $_SESSION["next_level_id"];

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//get numer of rows which will also be score needed
$numberOfRowsInCounting = pg_num_rows($result);

if ($numberOfRowsInCounting > 0)
{
	while ($row = pg_fetch_row($result))
	{
        	//fill php vars from db
		$scoreNeeded = $row[0];
		$start_number = $row[1];	
		$end_number = $row[2];	
		$count_by = $row[3];	

		for ($i=0; $i < $scoreNeeded; $i++)
		{	
			$q = $start_number + $i + $count_by -1;
			$a = $start_number + $i + $count_by;
        		echo "<script language=\"javascript\">";
        		echo "questions[$i] = \"What comes next after $q?\";";
        		echo "answers[$i] = $a";
        		echo "</script>";
		}
	}
	$numberOfRows = $scoreNeeded;
        echo "<script language=\"javascript\">";
	echo "scoreNeeded = $scoreNeeded;";
	echo "numberOfRows = $numberOfRows;";
        echo "</script>";
}



?>
