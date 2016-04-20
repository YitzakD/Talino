<?php $title = $menu['settings'][$_SESSION['locale']].' ['.$_SESSION['pseudo'].']'; ?>

<?php include "partials/_header_auth.php"; ?>
<div class="td-wrap">

    <div class="td-word-wrap">

        <div class="daf-gr- td-col-moy-small float-left margin-top-zx">
            <?php require "partials/settings/_settings.menu.php"; ?>
        </div>

        <div class="daf-sct-6 td-col-moy-big float-right margin-top-zx">
            <?php require "partials/_settings.founder.php"; ?>
        </div>

    </div>

    <div class="td-foo margin-top-lg">
        <?php include "partials/_footer_auth.php"; ?>
    </div>

</div>

<?php include "partials/_footer.php"; ?>