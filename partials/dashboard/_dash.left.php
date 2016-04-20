<div class="td-title">
    <div class="dds">
        <ul>
            <li class="has-sub dash-user-btn">
                <button class="btn info-user" type="button" tabindex="0">
                    <div class="dash-avatar">
                        <img alt="<?= e($user->pseudo); ?>"
                             src="<?= $user->avatar != '' ? set_avatar(e($user->id)) : get_avatar(); ?>"
                             class="img-small img-square" />
                    </div>
                    <span class="dash-user-pseudo dash-caret-down"><?= e($user->pseudo); ?>&nbsp;</span>
                </button>
                <ul class="bordered">
                    <li><a href="" class="dds-head">Vos organisations</a></li>
                    <li><span>Vous n'avez pas de tableaux associatves pour l'instant.</span></li>
                    <li><a href="new.board.php" class="dds-btm"><i class="fa fa-plus"></i>&nbsp;Créer un tableau associative</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<div class="td-content">
    <div class="td-dash-left-logo">
        <img src="assets/media/icon.png" class="img-small">
    </div>
    <div class="td-dash-left-info">
        <span class="td-dash-left-title">Bienvenue sur <?= WEBSITE_NAME ?>! Alors, vous faites quoi en suite?</span>
        <span class="td-dash-left-cnt">
            <span><a href="new.board.php" class="btn-link">Créer un tableau</a></span>
            <span><a href="settings.php?page=profile&id=<?= get_session('pseudo'); ?>" class="btn-link">Vous nous en dites plus sur vous</a></span>
            <span><a href="browse.an.associates.php" class="btn-link">Rechercher des associés</a></span>
            <span>Vous nous Suivez <a href="#" class="btn-link">@todo sur Twitter</a></span>
            Likez notre page <a href="#" class="btn-link">Todo sur Facebook</a> et restez au parfum.</span>
        </span>
        <span class="td-dash-left-lightbulb inlined no-margin margin-top-2x">
            <i class="fa fa-lightbulb-o fa-lg"></i>
            <b>Astuce!</b>
            Aider nous à trouver pour vous les bons asociés en
            <a href="settings.php?page=profile&id=<?= get_session('pseudo'); ?>" class="btn-link">completant</a>
            votre <a href="profile.php" class="btn-link">profile</a>
        </span>
    </div>
</div>