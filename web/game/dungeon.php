<?php
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_title_mootools.php");
include(getenv("DOCUMENT_ROOT") . "/src/database/db_connect.php");

//db connection
$conn = dbConnect();

include(getenv("DOCUMENT_ROOT") . "/web/game/standard_question_query.php");
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_games_attempts.php");
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_top.php");
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_control_object.php");
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_key.php");
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_door.php");
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_question_shapes.php");
include(getenv("DOCUMENT_ROOT") . "/web/game/standard_chasers.php?chasers=6");

include(getenv("DOCUMENT_ROOT") . "/web/game/standard_bottom.php");
?>

