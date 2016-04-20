<?php $title = $menu['board'][$_SESSION['locale']].' ['.$board->title.' - '.$_SESSION['pseudo'].']'; ?>

<?php include "partials/_header_auth.php"; ?>

<div class="td-board-world" id="js-big-list-containor">

    <div class="td-board-main-content">

        <div class="b-top-menu">
            <?php require "partials/boards/_board.navbar.php";  ?>
        </div>

        <div class="td-board-wrap" id="wrapper" style="background: <?= $board->background ? e($board->background) : '#ECF0F1' ?>">
            <?php require "partials/boards/_board.lists.notes.php"; ?>
        </div>

    </div>

</div>

<div class="push-menu" id="js-pusher-menu">
    <?php require "partials/boards/_board.menu.access.php" ?>
</div>


<div class="push-note">
    <?php require "partials/boards/_board.note.access.php" ?>
</div>

<?php include "partials/_footer.php"; ?>
