<?php
session_start();
require "../config/database.php";
require "../includes/functions.php";
require "../includes/constants.php";
require "../filters/auth.filter.php";
?>
<?php if(isset($_POST['bid']) && is_numeric($_POST['bid'])): ?>
<?php
    extract($_POST);

    $board = find_table_by_id($bid);
?>
<div class="td-content js-mb-menu-title" id="js-menu-one">
    <div class="mb-menu-title">
        <div class="blocked align-center text-size-2x" id="js-menu-title">Menu</div>
        <div class="divider"></div>
    </div>
</div>

<div class="td-content mb-menu-content" id="js-menu-box">
    <div class="td-div mb-user-infos blocked">
        <div class="span-horizontal-group blocked">
            <?php
                $user = find_user_by_id(get_session('user_id'));
            ?>
            <div class="span-in-left">
                <img class="img-small-lg img-square"
                     src="<?= $user->avatar != '' ? set_avatar(e(get_session('user_id'))) : get_avatar() ; ?>"
                     alt="Avatar de <?= e(get_session('pseudo')); ?>" />
            </div>
            <div class="span-in-right">
                <div class="span-vertical-group">
                    <div class="span-in-top text-size-zx td-color-grey align-left" style="font-size: 8px !important">PSEUDO</div>
                    <div class="span-in-bottom text-size-1x bolder align-left">
                        <a href="profile.php?id=<?= e(get_session('pseudo')); ?>"
                           class="btn-link bolder">
                            <?= e(get_session('pseudo')); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearer"></div>
    <div class="divider"></div>

    <div class="mb-ajust-menu margin-top-zx margin-bottoms-zx">
        <div class="mb-menu-link min-raduised cur-to-point" id="js-mb-color-btn">
            <span class="mb-background min-raduised" style="background: <?= $board->background; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
            &nbsp;
            <span class="bolder">Changer le fond du tableau</span>
        </div>

        <div class="mb-menu-link min-raduised not-activate" id="js-mb-outils-btn">
            <span class="fa fa-rocket fa-lg td-color-grey"></span>
            &nbsp;
            <span class="inlined bolder">Outils supplémentaires</span>&nbsp;<dt class="inlined text-size-zx">(Bientôt)</dt>
        </div>

        <div class="mb-menu-link min-raduised cur-to-point" id="js-mb-params-btn">
            <span class="fa fa-cog fa-lg mb-icon td-color-grey"></span>
            &nbsp;
            <span class="bolder">Paramètres</span>
        </div>

    </div>

    <div class="divider margin-bottoms-zx"></div>

    <div class="mb-ajust-menu margin-bottoms-zx">

        <div class="mb-menu-link min-raduised cur-to-point" id="js-mb-activities-btn">
            <span class="fa fa-align-left fa-lg td-color-grey"></span>
            &nbsp;
            <span class="inlined bolder">Activités</span>
        </div>

    </div>

    <div class="mb-some-activiies blocked" id="js-some-activities"></div>

</div>
<?php endif; ?>
