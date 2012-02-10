<html>

<!-- jquery and jqueryui -->
<link type="text/css" href="jquery-ui-1.8.17.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="jquery-1.7.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>

<body>
<?php

include("check_login.php");
include("db_connect.php");

//db connection
$conn = dbConnect();

//query
$query = "select name, start_number, score_needed, count_by, number_of_buttons from math_games where level = ";
$query .= $_SESSION["math_game_level"];
$query .= ";";

//get db result
$result = pg_query($conn,$query) or die('Could not connect: ' . pg_last_error());

//game variables to fill from db
$name = "";
$startNumber = 0;
$scoreNeeded = 0;
$countBy = 0;
$numberOfButtons = 0;

//get numer of rows
$num = pg_num_rows($result);

// if there is a row then id exists it better be unique!
if ($num > 0)
{
        //get row
        $row = pg_fetch_row($result);

        //fill php vars from db
        $name = $row[0];
        $startNumber = $row[1];
        $scoreNeeded = $row[2];
        $countBy = $row[3];
        $numberOfButtons = $row[4];
}

?>

<!-- class for game -->
<script type="text/javascript">

function Game(startNumber,scoreNeeded,countBy,numberOfButtons)
{
	//score
	this.score=0;
	this.scoreNeeded = scoreNeeded;

	//game
	this.numberOfButtons = numberOfButtons;
	this.question="";
	this.guess=0;
	this.answer=0;

	//count
	this.countBy = countBy;
	this.count=0;
	this.startNumber = startNumber;
}


//Score
Game.prototype.printScore = function()
{
        document.getElementById("score").innerHTML="Score: " + this.score;
        document.getElementById("scoreNeeded").innerHTML="Score Needed: " + this.scoreNeeded;
}

Game.prototype.checkForEndOfGame = function()
{
        if (this.score == <?php echo "$scoreNeeded"; ?> )
        {
                document.getElementById("feedback").innerHTML="YOU WIN!!!";
                window.location = "goto_next_math_level.php"
        }
}

//reset
Game.prototype.resetVariables = function()
{
	//score
	this.score = 0;

	//game
        this.question = "";
        this.guess = 0;
        this.answer = 0;

	//count
        this.count = this.startNumber;
}

//check guess
Game.prototype.checkGuess = function()
{
        if (this.guess == this.answer)
        {
                this.count = this.count + this.countBy;  //add to count
                this.score++;

                document.getElementById("feedback").innerHTML="Correct!";

                this.checkForEndOfGame();
        }
        else
        {
                document.getElementById("feedback").innerHTML="Wrong! Try again.";

                this.resetVariables();
        }
}

//questions
Game.prototype.newQuestion = function()
{
        //set question
        this.question = this.question + ' ' + this.count;
        document.getElementById("question").innerHTML=this.question;
}

//set choices
Game.prototype.setChoices = function()
{
        //set buttons
        var offset = Math.floor(Math.random() *4);
        offset = this.answer - offset;
        this.setButtons(offset);
}

//new answer
Game.prototype.newAnswer = function()
{
        this.answer = this.count + this.countBy;
}

//set buttons
Game.prototype.setButtons = function(offset)
{
	document.getElementById("buttonMoveLeft").innerHTML="left";
	document.getElementById("buttonMoveRight").innerHTML="right";
	document.getElementById("buttonMoveUp").innerHTML="up";
	document.getElementById("buttonMoveDown").innerHTML="down";
}


Game.prototype.moveLeft = function()
{
	alert('moveLeft');
}

var userWidth = window.screen.width;

Game.prototype.moveRight = function()
{

	//	alert('moveRight');
	var pp = document.getElementById("redball1");
	var lft = parseInt(pp.style.left);
	var tim = setTimeout("this.moveRightAgain()",20);  // 20 controls the speed
	lft = lft+5;  // move by 5 pixels
	pp.style.left = lft+"px";
	if (lft > userWidth + 10) 
	{  // left edge of image past the right edge of screen
		pp.style.left = -200;  // back to the left
		clearTimeout(tim);
	}
}

Game.prototype.moveRightAgain = function()
{
	this.moveRight();
}	

Game.prototype.moveUp = function()
{

	alert('moveUp');
}

Game.prototype.moveDown = function()
{

	alert('moveDown');
}

//submit guess
Game.prototype.submitGuess = function(button_id)
{
        this.guess = document.getElementById(button_id).innerHTML;
        
	this.checkGuess();
        
	this.newQuestion();
        this.newAnswer();
        this.setChoices();
        this.printScore();
}

Game.prototype.init = function()
{
	this.resetVariables();
	
	this.newQuestion();
	this.createImages('redball.gif',"question");
	this.newAnswer();
	this.setChoices();
	this.printScore();
}

Game.prototype.createButtons = function()
{



}


//create images
Game.prototype.createImages = function(imagesrc,appendTo)
{
	var img = new Image();   // Create new img element
       	img.src = imagesrc; // Set source path
	img.id = "redball1";
        document.getElementById(appendTo).appendChild(img);

}

</script>

<!-- end class for game -->

<!-- creating game -->
<script type="text/javascript">  var game = new Game( <?php echo "$startNumber,$scoreNeeded,$countBy,$numberOfButtons);"; ?> </script>

<!-- creat and set game name -->
<h1 = id="game_name"> <?php echo "$name"; ?> </h1>

<!-- create and set question -->
<p id="question"> </p>

<!-- Create Buttons (could this be done in db?) -->
        <button type="button" id="buttonMoveLeft" onclick="game.moveLeft(this.id)"> </button> 
        <button type="button" id="buttonMoveRight" onclick="game.moveRight(this.id)"> </button> 
        <button type="button" id="buttonMoveUp" onclick="game.moveUp(this.id)"> </button>
        <button type="button" id="buttonMoveDown" onclick="game.moveDown(this.id)"> </button> 

<!-- create feedback -->
<p id="feedback">"Have Fun!"</p>

<!-- create score -->
<p id="score"></p>

<!-- create scoreNeeded -->
<p id="scoreNeeded"></p>

<script type="text/javascript"> game.init(); </script>

</body>
</html>

