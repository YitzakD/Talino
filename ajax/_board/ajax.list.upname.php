<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<?php if(isset($_POST['html']) && isset($_POST['oldName']) && isset($_POST['lid']) && isset($_POST['bid'])
    && is_numeric($_POST['bid']) && is_numeric($_POST['lid'])): ?>

    <?php
    extract($_POST);

    $board = find_table_by_id($bid);

    $upList = e($html);

    $i = 1;
    $counter = $board->contributions+$i;

    $story_msg = "a modifier le nom de la liste '<i>".$oldName."</i>' en [<u>".$upList."</u>].";

    $q = $db->prepare("UPDATE board_list SET title=:title WHERE id=:id AND b_id=:b_id AND u_id=:u_id");

    set_contributions($bid, 'boards', $counter, get_session('user_id'));

    set_story_msg('', $story_msg, 'activities_story', get_session('user_id'), $bid);

    $q->execute([
        'title' => $upList,
        'id' => $lid,
        'b_id' => $bid,
        'u_id' => get_session('user_id')
    ]);

    $q->closeCursor();

    die("Saved");

    ?>

<?php else: ?>

    <div class='alert alert-danger set-alert-in-block blanco blocked margin-bottoms-zx' style='width: 89%'>
        Impossible de trouver cette note!<br />
        Raison: Le système n'a pas reconu l'identifiant de la note.<br/>
        Solution: Recharger la page en cliquant sur le lien ci-dessous.
    </div>
    <a href='' class='blocked btn-link margin-top-zx'><i class='fa fa-spinner fa-spin'></i>&nbsp;Recharger la page</a>

<?php endif; ?>

