<div class="td-header" <?= isset($_GET['b']) && $board->background != '#ECF0F1' ? 'style="background:'.e($board->background).'; border-bottom:'.e($board->background).'"': ''; ?>>
    <div class="in-header">
        <span class="h-logo">
            <a href="dashboard.php">
                <i class="fa fa-check"></i>
                <?= WEBSITE_NAME; ?>
            </a>
        </span>
        <ul class="menu float-right text-size-1x">
            <?php if(is_logged_in()): ?>
            <li>
                <a href="dashboard.php">Accueil</a>
                &nbsp;|&nbsp;&nbsp;
            </li>
            <li>
                <a href="profile.php?id=<?= get_session('pseudo'); ?>"><?= get_session('pseudo'); ?>&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                <ul class="menu-dropDown">
                    <li><a href="profile.php?id=<?= get_session('pseudo'); ?>"><i class="fa fa-align-left"></i><span>Mon fil d'activités</span></a></li>
                    <li><a href="profile.php?id=<?= get_session('pseudo'); ?>&tab=boards"><i class="fa fa-columns"></i><span>Mes tableaux</span></a></li>
                    <li><a href="allboards.php?id=<?= get_session('pseudo'); ?>&tab=stared"><i class="fa fa-dashboard"></i><span>En résumé</span></a></li>
                    <li class="divider"></li>
                    <li><a href="new.board.php"><i class="fa fa-plus"></i><span>Créer un tableau</span></a></li>
                </ul>
                &nbsp;|&nbsp;&nbsp;
            </li>
            <li>
                <a href="#users.list">&nbsp;<i class="fa fa-users"></i>&nbsp;</a>
            </li>
            <li>
                <a href="#notifications">&nbsp;<i class="fa fa-bell"></i>&nbsp;</a>
            </li>
            <li>
                <a href="settings.php?page=profile&id=<?= get_session('pseudo'); ?>">&nbsp;<i class="fa fa-cog"></i>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>&nbsp;</a>
                <ul class="menu-dropDown">
                    <li>
                        <a href="settings.php?page=profile&id=<?= get_session('pseudo'); ?>"><i class="fa fa-pencil"></i>
                            <span>Editer mon profile</span>
                        </a>
                    </li>
                    <li><a href="helps.php"><i class="fa fa-question"></i><span>Bésoins d'aides ?</span></a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-power-off"></i><span>Déconnexion</span></a></li>
                </ul>
            </li>

            <?php else: ?>
                <li class="<?= set_active('#ancre_home'); ?>">
                    <a href="#ancre_home">
                       <?= $menu['accueil'][$_SESSION['locale']]; ?>
                    </a>
                </li>
                <li class="<?= set_active('#ancre_register'); ?>">
                    <a href="#ancre_register">
                        <?= $menu['inscription'][$_SESSION['locale']]; ?>
                    </a>
                </li>
                <li class="<?= set_active('#ancre_login'); ?>">
                    <a href="#ancre_login">
                        <?= $menu['connexion'][$_SESSION['locale']]; ?>
                    </a>
                </li>
                <li class="<?= set_active('#ancre_contact'); ?>">
                    <a href="#ancre_contact">
                        <?= $menu['contact'][$_SESSION['locale']]; ?>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
