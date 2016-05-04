<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<?php if(isset($_POST['bid']) && isset($_POST['listname']) && is_numeric($_POST['bid'])): ?>

<?php

    extract($_POST);

    if(is_field_already_in_use_by_user($listname, 'board_list', get_session('user_id'), 'u_id', 'title')) {

        set_flash("Vous avez déjà une liste avec ce nom: <u>".$listname."</u>", "info");

    } else {

        $board = find_table_by_id($bid);

        $story_msg = "a avez créer un nouvelle liste: ".$listname.".";

        $i = 1;
        $counter = $board->contributions+$i;

        // CREATION
        $q = $db->prepare("INSERT INTO board_list(b_id, u_id, title) VALUES(:b_id, :u_id, :title)");

        set_contributions($bid, 'boards', $counter, get_session('user_id'));

        set_story_msg('', $story_msg, 'activities_story', get_session('user_id'), $bid);


        $q->execute([
            'b_id' => $bid,
            'u_id' => get_session('user_id'),
            'title' => $listname
        ]);

        $q->closeCursor();

        die("Saved");

    }
?>


<?php endif; ?>

