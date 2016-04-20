<div class="td-div bordered min-raduised">

    <div class="td-title bgc-title"><h3>Comment recevoir nos notifications</h3></div>

    <div class="td-content">

        <span class="blocked text-size-1x">
            Par défaut, vous recevez les notification <?= WEBSITE_NAME; ?> dans voite boîte mail principale.
        </span>

        <?= $mail_notif->notifications === '1' ? '<span class="blocked text-size-1x margin-top-zx">Votre adresse email qui
            reçoit les notifications actuellement est:&nbsp;<b>'.e($mail_notif->email).'</b>' : e($u_mail->email); ?>

    </div>

    <div class="divider"></div>

    <div class="td-content">

        <span class="blocked text-size-1x">
            Cela ne vous convient pas? vous pouvez changer l'adresse de réception des notifications.
        </span>

        <form class="form-group margin-top-zx" autocomplete="off" method="post">

            <label for="email">Adresse Email</label>
            <select name="email_to_notif" class="daf-form-ctrl minifierer inlined" required="required">
                <?php foreach ($usermails as $usermail): ?>
                    <option class="td-padding" value="<?= e($usermail->id); ?>"><?= e($usermail->email); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="set_notif_email_btn" value="Enregistrer" class="td-set-btn min-raduised inlined" />

        </form>

    </div>

    <div class="divider"></div>

    <div class="td-content text-size-zx">

        <i class="fa fa-question fa-lg text-danger"></i>&nbsp;
        Vous voulez ajouter une adresse email? rendez-vous sur l'onglet&nbsp;
        <a href="settings.php?page=emails&id=<?= get_session('user_id'); ?>" class="btn-link">Emails</a>.

    </div>

</div>