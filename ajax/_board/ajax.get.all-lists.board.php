<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<?php if(isset($_POST['bid']) && isset($_POST['theListKey']) && is_numeric($_POST['bid']) && is_numeric($_POST['theListKey'])): ?>

    <?php

    extract($_POST);

    $listID = $theListKey;

    $listes = find_in_table_by_external_key($bid, 'b_id', 'board_list', 'and u_id="'.get_session('user_id').'" and id !="'.$listID.'" order by id asc');
    ?>
    <select class='daf-form-ctrl' id='js-select-listID'>
        <option value="">Choisir une liste</option>
        <?php foreach($listes as $liste): ?>
            <option value="<?= e($liste->id); ?>"><?= e($liste->title); ?></option>
        <?php endforeach; ?>
    </select>
<?php endif;?>
