<?php
session_start();
require "../../../config/database.php";
require "../../../includes/functions.php";
require "../../../includes/constants.php";
require "../../../filters/auth.filter.php";
?>
<?php if(isset($_POST['bid']) && is_numeric($_POST['bid'])): ?>
<?php
    extract($_POST);

    $board = find_table_by_id($bid);

    $story_msg = "a fermé ce tableau: <b><u>".$board->title."</u></b>";

    $i = 1;
    $counter = $board->contributions+$i;

    $j = $db->prepare("UPDATE notes SET archivate=:archivate WHERE u_id=:u_id AND b_id=:b_id");
    $k = $db->prepare("UPDATE board_list SET archivate=:archivate WHERE u_id=:u_id AND b_id=:b_id");
    $q = $db->prepare("UPDATE boards SET archivate=:archivate WHERE u_id=:u_id AND id=:id");

    set_contributions($bid, 'boards', $counter, get_session('user_id'));

    set_story_msg('', $story_msg, 'activities_story', get_session('user_id'), $bid);

    $j->execute([
       'archivate' => '1',
       'u_id' => get_session('user_id'),
       'b_id' => $bid
    ]);
    $k->execute([
        'archivate' => '1',
        'u_id' => get_session('user_id'),
        'b_id' => $bid
    ]);
    $q->execute([
        'archivate' => '1',
        'u_id' => get_session('user_id'),
        'id' => $bid
    ]);

    $j->closeCursor();
    $k->closeCursor();
    $q->closeCursor();

    if($j && $k && $q) {
        ?><span id="js-pseudo-redirect"><?= get_session('pseudo'); ?></span><?php
        die("Closed");
    }

?>
<?php endif; ?>