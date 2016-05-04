<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<?php if(isset($_POST['bid']) &&
    isset($_POST['theListKey']) &&
    isset($_POST['newListID']) &&
    is_numeric($_POST['bid']) &&
    is_numeric($_POST['newListID']) &&
    is_numeric($_POST['theListKey'])): ?>

    <?php

    extract($_POST);
    $listID = $theListKey;
    $newIDList = $newListID;

    $oldList = find_one_id_in_table($listID, 'id', 'board_list', 'and b_id="'.$bid.'" and u_id="'.get_session('user_id').'"');

    $newList = find_one_id_in_table($newIDList, 'id', 'board_list', 'and b_id="'.$bid.'" and u_id="'.get_session('user_id').'"');

    $story_msg = "a déplacer les notes de la liste <i>".$oldList->title."</i> vers une liste: <b><u>".$newList->title."</u></b>.";

    $story_msg_deux = "a archiver une liste: <b><u>".$oldList->title."</u></b>.";

    $notes = find_in_table_by_external_key($listID, 'bl_id', 'notes', 'and b_id="'.$bid.'"');

    $board = find_table_by_id($bid);
    $i = 2;
    $counter = $board->contributions+$i;

    $q = $db->prepare("UPDATE board_list SET archivate=:archivate WHERE id=:id AND u_id=:u_id AND b_id=:b_id");

    $k = $db->prepare("UPDATE notes SET bl_id=:bl_id WHERE id=:id AND u_id=:u_id AND b_id=:b_id");

    foreach($notes as $note){
        $k->execute([
            'bl_id' => $newIDList,
            'id' => $note->id,
            'u_id' => get_session('user_id'),
            'b_id' => $bid
        ]);
    }

    set_contributions($bid, 'boards', $counter, get_session('user_id'));

    set_story_msg('', $story_msg, 'activities_story', get_session('user_id'), $bid);

    set_story_msg('', $story_msg_deux, 'activities_story', get_session('user_id'), $bid);

    $q->execute([
        'archivate' => '1',
        'id' => $listID,
        'u_id' => get_session('user_id'),
        'b_id' => $bid
    ]);

    die("Saved");

    ?>


<?php endif; ?>

