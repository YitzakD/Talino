<?php if(isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] === "profile") : ?>

    <?php include "partials/settings/_profile.settings.php"; ?>

<?php elseif(isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] === "admin"): ?>

    <?php include "partials/settings/_admin.settings.php"; ?>

<?php elseif(isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] === "emails"): ?>

    <?php include "partials/settings/_emails.settings.php"; ?>

<?php elseif(isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] === "notifications"): ?>

    <?php include "partials/settings/_notifications.settings.php"; ?>

<?php elseif(isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] === "admin.boards"): ?>

    <?php include "partials/settings/_boards.settings.php"; ?>

<?php elseif(isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] === "security"): ?>

    <?php include "partials/settings/_security.settings.php"; ?>

<?php endif; ?>
