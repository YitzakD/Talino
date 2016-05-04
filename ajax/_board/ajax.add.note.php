<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<?php if(isset($_POST['lid']) && isset($_POST['bid']) && isset($_POST['notename']) && is_numeric($_POST['lid']) && is_numeric($_POST['bid'])): ?>

<?php

    extract($_POST);

    $board = find_table_by_id($bid);

    $listinfos = find_one_id_in_table($lid, 'id', 'board_list');

    $story_msg = "a créer une nouvelle note: <u>".$notename."</u> dans cette liste: <b><u>".$listinfos->title."</u></b>.";

    $i = 1;
    $counter = $board->contributions+$i;

    $q = $db->prepare("INSERT INTO notes(bl_id, b_id, u_id, note, created_at) VALUES(:bl_id, :b_id, :u_id, :note, :created_at)");

    set_contributions($bid, 'boards', $counter, get_session('user_id'));

    set_story_msg('', $story_msg, 'activities_story', get_session('user_id'), $bid);

    $q->execute([
        'bl_id' => $lid,
        'b_id' => $bid,
        'u_id' => get_session('user_id'),
        'note' => e($notename),
        'created_at' => date('Y-m-d H:i:s')
    ]);

    $q->closeCursor();

    die("Saved");

?>


<?php endif; ?>

