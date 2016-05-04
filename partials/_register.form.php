<div class="singnup">

    <form method="post" action="#ancre_register" class="add_form" autocomplete="off">

        <h1>Créer un compte <?= WEBSITE_NAME; ?></h1>

        <label for="pseudo">Pseudo<b class="text-danger">*</b></label>

        <input type="text" name="pseudo" id="pseudo" class="form_input" value="<?= get_input('pseudo'); ?>" placeholder="ex., Innocent" required="required" />

        <label for="email">E-mail<b class="text-danger">*</b></label>

        <input type="email"
               name="email" id="email"
               class="form_input" value="<?= get_input('email'); ?>"
               placeholder="ex., innoss.1203@talino.com" required="required" />

        <label for="password">Mot de passe<b class="text-danger">*</b></label>

        <input type="password" name="password" id="password" class="form_input" placeholder="ex., ******" required="required" />

        <input type="submit" name="sign_up" value="Créer un nouveau compte" class="form_input_validate" />

    </form>

    <p class="add_left">Avez-vous déjà un compte ? <a href="#ancre_login">Connectez-vous</a>.</p>

</div>