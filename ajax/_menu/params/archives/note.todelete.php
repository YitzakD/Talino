<?php
session_start();
require "../../../../config/database.php";
require "../../../../includes/functions.php";
require "../../../../includes/constants.php";
require "../../../../filters/auth.filter.php";

if(isset($_POST['_noteDelete']) && is_numeric($_POST['_noteDelete'])) {

    extract($_POST);

    $_nid = $_noteDelete;

    $note = find_one_id_in_table($_nid, 'id', 'notes');

    $board = find_table_by_id($note->b_id);

    $story_msg = "a supprimé cette note: <u>".$note->note."</u>";

    $i = 1;
    $counter = $board->contributions+$i;

    set_contributions($note->b_id, 'boards', $counter, get_session('user_id'));

    set_story_msg('', $story_msg, 'activities_story', get_session('user_id'), $note->b_id);

    $q = delete_x_by_table($_nid, 'id', 'notes');

    die("Deleted");

}