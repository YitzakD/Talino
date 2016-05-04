<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<?php if(isset($_POST['bid']) && is_numeric($_POST['bid'])): ?>

    <?php
    extract($_POST);
    $q = $db->prepare("SELECT * FROM activities_story WHERE u_id=:u_id AND b_id=:b_id ORDER BY id DESC");

    $q->execute([
        'u_id' => get_session('user_id'),
        'b_id' => $bid
    ]);

    $data = $q->fetchAll(PDO::FETCH_OBJ);

    $q->closeCursor();

    $activities = $data

    ?>
    <div class="td-content js-mb-menu-title" id="js-menu-one">
        <div class="mb-menu-title">
            <div class="blocked text-size-2x">
                <div class="inlined float-left align-center cur-to-point" id="js-close-opened" style="width: 40px;">
                    <i class="fa fa-arrow-left btn-link unerderlined"></i>
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="inlined float-left align-center" id="js-menu-title" style="width: auto">
                    Activités
                </div>
            </div>
            <div class="divider"></div>
        </div>
    </div>

    <div class="td-content mb-menu-content" id="js-menu-box">
    <?php if($activities): ?>

        <?php foreach($activities as $activity): ?>

            <div class="mb-s-activities blocked span-horizontal-group">
                <?php
                $user = find_user_by_id(get_session('user_id'));
                ?>
                <div class="span-in-left inlined float-left">
                    <img class="img-small img-square"
                         src="<?= $user->avatar != '' ? set_avatar(e(get_session('user_id'))) : get_avatar() ; ?>"
                         alt="Avatar de <?= e(get_session('pseudo')); ?>" />
                </div>

                <div class="mb-s-activity span-in-right inlined float-right text-size-1x">
                    <?= '<b>'.get_session('pseudo').'</b>&nbsp;'.$activity->description; ?>
                    <?php
                    $timestamp = new DateTime($activity->created_at);
                    $timestamp->getTimestamp();
                    $timestamp = $timestamp->format('U');
                    ?>
                    <span class="timeago text-size-zx td-color-grey"><?= set_time($timestamp); ?></span>
                </div>

            </div>

        <?php endforeach; ?>

        <div class="clearer"></div>

        <div class="mb-ajust-menu margin-bottom-2x"></div>

    <?php else: ?>

        <p class="blocked td-color-grey bolder text-size-2x align-center">Vos n'avez pas d'activités sur ce tableau.</p>

    <?php endif; ?>

    </div>

<?php endif; ?>