<?php
//------------standard top of file
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_title_mootools.php");

//-----------------database
include(getenv("DOCUMENT_ROOT") . "/src/database/db_connect.php");

//db connection
$conn = dbConnect();


include(getenv("DOCUMENT_ROOT") . "/web/game/standard_sessions.php");
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_games_query.php");
//question_query????
//don't need games_attempts...
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_game_includes.php");
?>

<script type="text/javascript" src="/src/game/chooser.php"></script>
<script type="text/javascript" src="/web/game/standard_game_hud.php"></script>

</head>

<body bgcolor="grey">

<script language="javascript">

var mGame;
var mApplication;

window.addEvent('domready', function()
{

        //APPLICATION
        mApplication = new Application();

	//GAME
	mGame = new Chooser("Chooser");

        //QUIZ
        mQuiz = new Quiz(1);
        mGame.mQuiz = mQuiz;

        //create questions
        mGame.createQuestions();

        //create control object
        mGame.createControlObject("/images/characters/wizard.png");

        //create question shapes
        //mGame.createQuestionShapes();

        //create doors
        mGame.createDoors();

        //KEYS
        document.addEvent("keydown", mApplication.keyDown);
        document.addEvent("keyup", mApplication.keyUp);

<?php
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_bottom.php");
?>

