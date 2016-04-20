<div class="td-div bordered min-raduised"><!-- Bloc d'edition de mot de passe -->

    <div class="td-title bgc-title"><h3>Changer mon mot de passe</h3></div>

    <div class="td-content">

        <?php include "partials/_errors_in.php"; ?>

        <form class="form-group" autocomplete="off" method="post">

            <label for="current_pass">Mot de passe (ancien)<b class="text-danger">*</b></label>
            <input type="password" name="current_pass" id="current_pass"
                   class="daf-form-ctrl midlerer"
                   placeholder="Entrer votre mot de passe actuel"
                   required="required" />

            <label for="new_pass">Nouveau mot de passe<b class="text-danger">*</b></label>
            <input type="password" name="new_pass" id="new_pass"
                   class="daf-form-ctrl midlerer"
                   placeholder="Entrer un nouveau mot de passe"
                   required="required" />

            <label for="confirmed_pass">Confirmer le mot de passe<b class="text-danger">*</b></label>
            <input type="password" name="confirmed_pass" id="confirmed_pass"
                   class="daf-form-ctrl midlerer"
                   placeholder="Confirmer le nouveau mot de passe"
                   required="required" />

            <input type="submit" name="change_psw_btn" value="Modifier mon mot de passe" class="td-set-btn td-padding min-raduised" />

        </form>

    </div>

    <div class="divider"></div>

    <div class="td-content text-size-zx">

        <i class="fa fa-question fa-lg text-danger"></i>&nbsp;Vous avez oublier votre mot de passe? Vous pouvez le
        <a href="settings.php?page=password.reset&id=<?= get_session('user_id'); ?>" class="btn-link">réinitialiser</a>.

    </div>

</div>

<div class="td-div bordered min-raduised margin-top-1x"><!-- Bloc de supression de Compte -->

    <div class="td-title td-bgc-danger blanco unerderlined text-shadowed"><h3>Supprimer mon compte</h3></div>

    <div class="td-content">

        <span class="text-size-1x blocked">
            Quand vous supprimer votre compte, il n'y a pas de retour en arrière possible. Soyez donc certain de votre action.
        </span>

        <div class="margin-bottoms-zx"></div>
        <form action="settings.php?page=admin&id=<?= get_session('user_id'); ?>" autocomplete="off" method="post">
            <input type="hidden" value="<?= get_session('user_id'); ?>">
            <button type="submit" name="delete_user_btn" class="btn btn-warm">
                <i class="fa fa-trash-o"></i>&nbsp;Supprimer mon compte
            </button>
        </form>

    </div>

</div>