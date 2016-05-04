<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<?php if(isset($_POST['colorcode']) && isset($_POST['bid']) && is_numeric($_POST['bid'])): ?>

    <?php

    extract($_POST);

    $board = find_table_by_id($bid);

    $upColor = $colorcode;

    $story_msg = "a changé la couleur fond de son tableau: <b><u>".$board->title."</u></b>.";

    $i = 1;
    $counter = $board->contributions+$i;

    $q = $db->prepare("UPDATE boards SET background = :background WHERE id = :id AND u_id = :u_id");

    set_contributions($bid, 'boards', $counter, get_session('user_id'));

    set_story_msg('', $story_msg, 'activities_story', get_session('user_id'), $bid);

    $q->execute([
        'background' => $upColor,
        'id' => $bid,
        'u_id' => get_session('user_id'),
    ]);

    $q->closeCursor();

    if($q) {

        die("Saved");

    }

    ?>

<?php endif; ?>

