<?php

//brian - get current date
$_SESSION["game_start_time"] = date('Y-m-d H:i:s');
$_SESSION["game_over"] = "false";

include(getenv("DOCUMENT_ROOT") . "/src/database/insert_into_games_attempts.php");

//brian - attempt a game - still hardcoding game_id = 1
insertIntoGamesAttempts($conn,$_SESSION["game_start_time"],1,$_SESSION["user_id"],$_SESSION["next_level"]);
?>

<script language="javascript">
var curDate = "<?php echo $curDate; ?>";
var username = "<?php echo $username; ?>";
var next_level = "<?php echo $next_level; ?>";
</script>

<script type="text/javascript" src="/src/math/point2D.php"></script>
<script type="text/javascript" src="/src/bounds/bounds.php"></script>
<script type="text/javascript" src="/src/game/game.php"></script>
<script type="text/javascript" src="/src/application/application.php"></script>
<script type="text/javascript" src="/src/animation/animation.php"></script>
<script type="text/javascript" src="/src/animation/animation_advanced.php"></script>
<script type="text/javascript" src="/src/shape/shape.php"></script>
<script type="text/javascript" src="/src/shape/shape_player.php"></script>
<script type="text/javascript" src="/src/shape/shape_door.php"></script>
<script type="text/javascript" src="/src/shape/shape_ai.php"></script>
<script type="text/javascript" src="/src/div/div.php"></script>
<script type="text/javascript" src="/src/question/question.php"></script>
<script type="text/javascript" src="/src/quiz/quiz.php"></script>
<script type="text/javascript" src="/src/hud/hud.php"></script>


</head>

<body bgcolor="grey">

<script language="javascript">
var mGame;
var mApplication;

window.addEvent('domready', function()
{
        //APPLICATION
        mApplication = new Application();

        //KEYS
        document.addEvent("keydown", mApplication.keyDown);
        document.addEvent("keyup", mApplication.keyUp);

        //BOUNDS AND HUD COMBO
        mBounds = new Bounds(60,735,380,35);

        mHud = new Hud();
        mHud.mScoreNeeded.setText('<font size="2"> Needed : ' + scoreNeeded + '</font>');
        mHud.mGameName.setText('<font size="2">DUNGEON</font>');

        //GAME
        mGame = new Game("hardcode");

        //QUIZ
        mQuiz = new Quiz(scoreNeeded);
        mGame.mQuiz = mQuiz;

        //QUESTIONS FOR QUIZ
        for (i = 0; i < scoreNeeded; i++)
        {
                var question = new Question(questions[i],answers[i]);
                mQuiz.mQuestionArray.push(question);
        }




