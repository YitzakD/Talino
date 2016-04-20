<div class="td-div bordered min-raduised"><!-- Bloc d'edition d'avatar -->

    <div class="td-title bgc-title"><h3>Avatar</h3></div>

    <div class="td-content">

        <form id="avatarForm" class="form-group" autocomplete="off" method="post" enctype="multipart/form-data">

            <label for="avatar">Image de profile</label>
            <div class="span-horizontal-group">
                <div class="span-in-left">
                    <img src="<?= $user->avatar != '' ? set_avatar(e($user->id)) : get_avatar(); ?>"
                         class="img-middle img-square"
                         id="s-avatar-up" />
                </div>
                <div class="span-in-right" id="ajaxUploadAvatar">
                    <div class="fack-file-inputer">
                        <input type="file" name="set_img" required="required" id="set_img" />
                        <a href="#" class="td-like-btn bordered min-raduised td-padding unerderlined bolder">
                            <span>Choisir une nouvelle image</span>
                        </a>
                    </div>
                    <span class="s-mini-pub text-size-1x">
                        <div class="progress" id="progress">
                            <div class="bar"></div >
                            <div class="percent td-color-ld"><i class="fa fa-check"></i></div >
                        </div>
                        <!--<div class="margin-bottoms-zx" id="loading"><i class="fa fa-spin fa-spinner"></i></div> -->
                        <div class="margin-bottoms-zx" id="errormes"></div>
                        <i class="fa fa-lightbulb-o fa-lg"></i>&nbsp;
                        Grâce à notre algorithme de compression, vos images perdent du poids, mais pas de leur qualité!
                    </span>
                </div>
            </div>

            <input type="submit" name="set_up_avatar_btn" value="Sauvegarder l'avatar" id="set_avatarForm" class="td-set-btn td-padding min-raduised" />

        </form>

    </div>

</div>

<div class="td-div bordered min-raduised margin-top-zx"><!-- Bloc d'edition infos -->

    <div class="td-title bgc-title"><h3>Profile publique</h3></div>

    <div class="td-content">

        <?php include_once "partials/_errors.php"; ?>

        <form class="form-group" autocomplete="off" method="post">

            <label for="name">Nom<b class="text-danger">*</b></label>
            <input type="text" name="name" id="name" class="daf-form-ctrl midlerer"
                   value="<?= get_input('name') ?: e($user->name); ?>"
                   placeholder="ex., Christophe KOUAME"
                   required="required" />

            <label for="sex">Sexe</label>
            <select name="sex" id="sex" class="daf-form-ctrl smallerfier" required="required">
                <option value="F" <?= $user->sex == "F" ? "selected" : ""; ?>>Femme</option>
                <option value="H" <?= $user->sex == "H" ? "selected" : ""; ?>>Homme</option>
            </select>

            <label for="city">Ville<b class="text-danger">*</b></label>
            <input type="text" name="city" id="city" class="daf-form-ctrl midlerer"
                   value="<?= get_input('city') ?: e($user->city); ?>"
                   placeholder="ex., San Francisco"
                   required="required" />

            <label for="country">Pays<b class="text-danger">*</b></label>
            <input type="text" name="country" id="country" class="daf-form-ctrl midlerer"
                   value="<?= get_input('country') ?: e($user->country); ?>"
                   placeholder="ex., USA (United State of America)"
                   required="required" />

            <label for="facebook"><i class="fa fa-facebook"></i>acebook</label>
            <input type="text" name="facebook" id="facebook" class="daf-form-ctrl minifierer"
                   value="<?= get_input('facebook') ?: e($user->facebook); ?>"
                   placeholder="ex., chris.Kouame"
            />

            <label for="twitter"><i class="fa fa-twitter"></i>&nbsp;Twitter</label>
            <input type="text" name="twitter" id="twitter" class="daf-form-ctrl minifierer"
                   value="<?= get_input('twitter') ?: e($user->twitter); ?>"
                   placeholder="ex., christKouame"
            />

            <label for="bio">Biographie<b class="text-danger">*</b></label>
            <textarea name="bio" id="bio td_textarea" class="daf-form-ctrl set-in-block"
                      placeholder="Décrivver vous en quelques lignes."
                      required="required"><?= get_input('bio') ?: e($user->bio); ?></textarea>

            <input type="submit" name="set_up_ui_btn" value="Editer mon profile" class="td-set-btn min-raduised"  />

        </form>

    </div>

    <div class="divider"></div>

    <div class="td-content text-size-zx">

        <i class="fa fa-question fa-lg text-danger"></i>

        <span>
            Voulez-vous modifier votre aderesse Email? Vous pouvez trouver le bon fourmulaire sous l'onglet
            <a href="settings.php?page=emails&id=<?= get_session('user_id'); ?>" class="btn-link">Emails</a>.
        </span>

    </div>

</div>