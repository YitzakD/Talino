<div class="td-div bordered min-raduised">

    <div class="td-title bgc-title"><h4>Paramètres personels</h4></div>

    <div class="s-menu">

        <div>
            <a href="settings.php?page=profile&id=<?= get_session('pseudo'); ?>"
               class="s-menu-link btn-link text-size-1x unerderlined <?php set_settings_menu_active('profile'); ?>">
                Profile
            </a>
        </div>

        <div>
            <a href="settings.php?page=admin&id=<?= get_session('pseudo'); ?>"
               class="s-menu-link btn-link text-size-1x unerderlined <?php set_settings_menu_active('admin'); ?>">
                Compte
            </a>
        </div>

        <div>
            <a href="settings.php?page=emails&id=<?= get_session('pseudo'); ?>"
               class="s-menu-link btn-link text-size-1x unerderlined <?php set_settings_menu_active('emails'); ?>">
                Emails
            </a>
        </div>

        <div>
            <a href="settings.php?page=notifications&id=<?= get_session('pseudo'); ?>"
               class="s-menu-link btn-link text-size-1x unerderlined <?php set_settings_menu_active('notifications'); ?>">
                Notifications
            </a>
        </div>

        <div>
            <a href="settings.php?page=admin.boards&id=<?= get_session('pseudo'); ?>"
               class="s-menu-link btn-link text-size-1x unerderlined <?php set_settings_menu_active('admin.boards'); ?>">
                Tableaux
            </a>
        </div>

        <div>
            <a href="settings.php?page=security&id=<?= get_session('pseudo'); ?>"
               class="s-menu-link btn-link text-size-1x unerderlined <?php set_settings_menu_active('security'); ?>">
                Sécurité
            </a>
        </div>

    </div>

</div>