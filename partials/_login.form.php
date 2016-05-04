<div class="login">

    <form method="post" action="#ancre_login" class="log_form" autocomplete="off">

        <h1>Se connecter à <?= WEBSITE_NAME; ?></h1>

        <label for="identifiant">Pseudo ou Adresse mail<b class="text-danger">*</b></label>

        <input type="text" name="identifiant"
               id="identifiant" class="form_input"
               value="<?= get_input('identifiant'); ?>"
               placeholder="ex., Innocent|innoss.1203@talino.com" required="required" />

        <label for="password">Mot de passe<b class="text-danger">*</b></label>

        <input type="password" name="password" id="password" class="form_input" placeholder="ex., ******" required="required" />

        <label for="rememberme">
            <input type="checkbox" name="rememberme" id="rememberme" />
            Garder ma session active.
        </label>

        <input type="submit" name="login_in" value="Se connecter" class="form_input_validate" />

    </form>

    <p class="log_left text-size-lg">Mot de passe oublié ? <a href="reinitialize.php">Réinitialiser</a>.</p>

    <p class="log_left text-size-1x">Vous n'avez pas encore de compte ? <a href="#ancre_register">Créer un compte <?= WEBSITE_NAME; ?></a>.</p>

</div>