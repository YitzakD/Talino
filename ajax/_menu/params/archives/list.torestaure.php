<?php
session_start();
require "../../../../config/database.php";
require "../../../../includes/functions.php";
require "../../../../includes/constants.php";
require "../../../../filters/auth.filter.php";

if(isset($_POST['_listeRestaure']) && is_numeric($_POST['_listeRestaure'])) {

    extract($_POST);

    $_lid = $_listeRestaure;

    $liste = find_one_id_in_table($_lid, 'id', 'board_list');

    $board = find_table_by_id($liste->b_id);

    $story_msg = "a restauré cette liste: <u>".$liste->title."</u>";

    $i = 1;
    $counter = $board->contributions+$i;

    $q = $db->prepare("UPDATE board_list SET archivate=:archivate WHERE id=:id AND u_id=:u_id AND b_id=:b_id");

    set_contributions($liste->b_id, 'boards', $counter, get_session('user_id'));

    set_story_msg('', $story_msg, 'activities_story', get_session('user_id'), $liste->b_id);

    $q->execute([
        'archivate' => '0',
        'id' => $_lid,
        'u_id' => get_session('user_id'),
        'b_id' => $liste->b_id,
    ]);

    $q->closeCursor();

    if($q) {

        die("Reataured");

    }

}