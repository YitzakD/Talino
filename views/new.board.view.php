<?php $title = $menu['new.boards'][$_SESSION['locale']].' ['.$_SESSION['pseudo'].']'; ?>

<?php include "partials/_header_auth.php"; ?>
<div class="td-wrap">

    <div class="td-word-wrap">

        <div class="newboard-wrap margin-top-lg">

            <div class="td-title">
                <span class="nb-title-2x">Créer un nouveau tableau</span>
                <span class="nb-title-lg">Un tableau, c'est comme un dossier dans lequel sera stocké vos informations.</span>
            </div>

            <?php include_once "partials/_errors_in.php"; ?>

            <?php require "partials/new.board/_new.board_form.php"; ?>

        </div>

    </div>

    <div class="td-foo margin-top-lg">
        <?php include "partials/_footer_auth.php"; ?>
    </div>

</div>

<?php include "partials/_footer.php"; ?>
