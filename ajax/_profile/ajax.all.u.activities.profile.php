<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<?php if(isset($_POST['uid']) && is_numeric($_POST['uid']) && $_POST['uid'] === get_session('user_id')): ?>
    <?php
    extract($_POST);
    $user = find_user_by_id($uid);

    $activities = find_in_table_by_external_key($uid, 'u_id', 'activities_story', 'order by id desc');

    ?>
    <?php if($activities): ?>

        <?php foreach($activities as $activity): ?>
            <div class="blocked">
                <div class="act-avatar-box">
                    <img src="<?= $user->avatar != '' ? set_avatar(e($user->id)) : get_avatar(); ?>"
                         alt="<?= e($user->pseudo); ?>"
                         class="img-small min-raduised" />
                </div>
                <div class="act-activity-box cur-to-point min-raduised margin-bottoms-zx">
                    <?= $activity->description; ?>
                    <div class="margin-top-zx divider"></div>
                    <?php
                    $timestamp = new DateTime($activity->created_at);
                    $timestamp->getTimestamp();
                    $timestamp = $timestamp->format('U');
                    ?>
                    <span class="timeago float-right text-size-zx td-color-grey"><?= set_time($timestamp); ?></span>
                </div>
            </div>
            <div class="margin-bottoms-zx"></div>
        <?php endforeach; ?>

    <?php endif; ?>

<?php endif ?>
