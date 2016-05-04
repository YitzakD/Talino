<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<?php if(isset($_POST['newliste'])
    && isset($_POST['note_id'])
    && isset($_POST['bid'])
    && is_numeric($_POST['newliste'])
    && is_numeric($_POST['note_id'])
    && is_numeric($_POST['bid'])
): ?>

    <?php

    extract($_POST);

    $board = find_table_by_id($bid);

    $upListe = e($newliste);

    $j = find_one_id_in_table($note_id, 'id', 'notes');
    $listinfos = find_one_id_in_table($upListe, 'id', 'board_list');

    $story_msg = "a déplacer une note: <u>".$j->note."</u> vers une autre liste: <b><u>".$listinfos->title."</u></b>.";

    $i = 1;
    $counter = $board->contributions+$i;

    $q = $db->prepare("INSERT INTO notes(bl_id, b_id, u_id, note, created_at, background, description, note_file, archivate) VALUES(:bl_id, :b_id, :u_id, :note, :created_at, :background, :description, :note_file, :archivate)");

    set_contributions($bid, 'boards', $counter, get_session('user_id'));

    set_story_msg('', $story_msg, 'activities_story', get_session('user_id'), $bid);

    $q->execute([
        'bl_id' => $upListe,
        'b_id' => $j->b_id,
        'u_id' => $j->u_id,
        'note' => $j->note,
        'created_at' => $j->created_at,
        'background' => $j->background,
        'description' => $j->description,
        'note_file' => $j->note_file,
        'archivate' => $j->archivate
    ]);

    delete_x_by_table($j->id, 'id', 'notes');

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

