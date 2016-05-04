<?php $title = $menu['allboards'][$_SESSION['locale']].' ['.$_SESSION['pseudo'].']'; ?>

<?php include "partials/_header_auth.php"; ?>

<div class="td-wrap">

    <div class="td-word-wrap">

        <div class="daf-sct-10 td-col-max-big-plus float-left margin-top-zx">
            <?php include "partials/allboards/_allboards.all.php"; ?>
        </div>

    </div>

    <div class="td-foo margin-top-lg">
        <?php include "partials/_footer_auth.php"; ?>
    </div>

</div>

<?php include "partials/_footer.php"; ?>