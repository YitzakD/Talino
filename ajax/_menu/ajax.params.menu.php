<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<div class="td-content js-mb-menu-title" id="js-menu-one">
    <div class="mb-menu-title">
        <div class="blocked text-size-2x">
            <div class="inlined float-left align-center cur-to-point" id="js-close-opened" style="width: 40px;">
                <i class="fa fa-arrow-left btn-link unerderlined"></i>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div class="inlined float-left align-center" id="js-menu-title" style="width: auto">
                Paramètres
            </div>
        </div>
        <div class="divider"></div>
    </div>
</div>
<?php if(isset($_POST['bid']) && is_numeric($_POST['bid'])): ?>
<?php
    extract($_POST);
    $board = find_table_by_id($bid);
?>

<div class="td-content mb-menu-content" id="js-menu-box">

    <div class="mb-ajust-menu margin-bottoms-zx">

        <div class="text-size-1x td-color-grey align-center margin-top-zx">
            <span class="text-danger"><?= get_table_icon($board->status); ?></span>Privé.
            &nbsp;Ce tableau n'est visible que par vous.
        </div>

        <div class="divider margin-top-zx margin-bottoms-zx"></div>

        <div class="mb-menu-link min-raduised cur-to-point" id="js-prm-etiqs-btn">
            <span class="fa fa-filter fa-lg mb-icon td-color-grey"></span>
            &nbsp;
            <span class="bolder">Filtrer les notes</span>
        </div>

        <div class="mb-menu-link min-raduised cur-to-point" id="js-prm-archs-btn">
            <span class="fa fa-archive fa-lg mb-icon td-color-grey"></span>
            &nbsp;
            <span class="inlined bolder">Eléments archivés</span>
        </div>

        <div class="mb-menu-link min-raduised cur-to-point not-activate" id="js-prm-copy-btn">
            <span class="fa fa-copy fa-lg mb-icon td-color-grey"></span>
            &nbsp;
            <span class="inlined bolder">Copier le tableau</span>
        </div>

        <div class="divider margin-top-zx margin-bottoms-zx"></div>

        <div class="mb-menu-link min-raduised cur-to-point" id="js-prm-close-btn">
            <span class="fa fa-times fa-lg mb-icon td-color-grey"></span>
            &nbsp;
            <span class="bolder">Fermer le tableau</span>
        </div>
        <div class="divider margin-top-zx"></div>

    </div>

</div>
<?php else: ?>
<?php die("No more params"); ?>
<?php endif; ?>
