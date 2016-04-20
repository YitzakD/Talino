<?php $title = $menu['dashboard'][$_SESSION['locale']].' ['.$_SESSION['pseudo'].']'; ?>

<?php include "partials/_header_auth.php"; ?>
<div class="td-wrap">

    <div class="td-word-wrap">

        <div class="daf-sct-5 td-col-min-big float-left margin-top-zx">
            <?php include "partials/dashboard/_dash.left.php"; ?>
        </div>

        <div class="daf-gr-5 td-col-max-small float-right margin-top-zx bordered min-raduised">
            <?php include "partials/dashboard/_dash.right.php"; ?>
        </div>

    </div>

    <div class="td-foo margin-top-lg">
        <?php include "partials/_footer_auth.php"; ?>
    </div>

</div>

<?php include "partials/_footer.php"; ?>