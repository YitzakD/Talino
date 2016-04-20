<?php $title = $menu['profile'][$_SESSION['locale']].' ['.$_SESSION['pseudo'].']'; ?>

<?php include "partials/_header_auth.php"; ?>

<div class="td-wrap">

    <div class="td-word-wrap">

        <div class="daf-gr-5 td-col-min-small float-left margin-top-zx">
            <?php include "partials/profile/_profile.left.php";  ?>
        </div>

        <div class="daf-sct-5 td-col-max-big float-right margin-top-zx">
            <?php include "partials/profile/_profile.right.php";  ?>
        </div>

    </div>

    <div class="td-foo margin-top-lg">
        <?php include "partials/_footer_auth.php"; ?>
    </div>

</div>

<?php include "partials/_footer.php"; ?>
