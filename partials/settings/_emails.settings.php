<div class="td-div bordered min-raduised"><!-- Bloc d'ajout et supression de mail -->

    <div class="td-title bgc-title"><h3>Email</h3></div>

    <div class="td-content">
        <div class="td-blocked text-size-1x">
            L'adresse <b>Email principale</b> est généralement utilisée pour se connecter, c'est aussi à cette adresse que <?= WEBSITE_NAME; ?>
            vous enverra les notifications et les messages en rapport avec la plateforme, les partenaires et vos différentes opérations.
        </div>
    </div>

    <?php if($usermailcount): ?>
        <?php foreach ($usermails as $usermail):?>
            <div class="td-content text-size-1x">
                <div class="blocked"><?= e($usermail->email) ?>&nbsp;
                    <?= $usermail->re_order === "1"
                        ? '<span class="spanit reorder-primary min-raduised">Principale</span>'
                        : '<span class="spanit reorder-secondary min-raduised">Sécondaire</span>';
                    ?>
                    <?= $usermail->status === "Private"
                        ? '<span class="spanit status-private min-raduised">Privée</span>'
                        : '<span class="spanit status-public min-raduised">Publique</span>';
                    ?>
                    <?= $usermail->re_order === '2'
                        ? '<span class="float-right">'
                            .'<form class="form-group inlined" action="settings.php?page=emails&id='.get_session('pseudo').'" method="post">'
                                .'<input type="hidden" name="mail_id_to_set" value="'.e($usermail->id).'">'
                                .'<button type="submit" class="spanit btn-primary min-raduised" name="mail_to_set">Comptre principal'
                                .'</button>'
                            .'</form>'
                            .'&nbsp;'
                            .'<form class="form-group inlined" action="settings.php?page=emails&id='.get_session('pseudo').'" method="post">'
                                .'<input type="hidden" name="mail_id_to_delete" value="'.e($usermail->id).'">'
                                .'<button type="submit" class="spanit btn-warm min-raduised" name="mail_to_delete"><i class="fa fa-trash-o"></i>'
                                .'</button>'
                            .'</form>'
                          .'</span>'
                        : '';
                    ?>
                </div>
            </div>
            <div class="divider"></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="td-content">
        <form class="form-group" autocomplete="off" method="post">
            <label for="new_mail">Ajouter une adresse Email</label>
            <input type="email" name="new_mail" id="new_mail" class="daf-form-ctrl minifierer inlined"
                   placeholder="ex., madeuxiemeadresse@todo.io"
                   required="required" />
            &nbsp;
            <input type="submit" name="add_new_mail_btn" value="Ajouter" class="td-set-btn min-raduised inlined" />
        </form>
    </div>

    <div class="divider"></div>

    <div class="td-content text-size-zx">

        <i class="fa fa-info fa-lg text-danger"></i>&nbsp;Vous pouvez ajouter autant d'adresse email que vous en avez!

    </div>

</div>

<div class="td-div bordered min-raduised margin-top-1x"><!-- bloc de mise en public et private -->

    <div class="td-title bgc-title"><h3>Préferences</h3></div>

    <div class="td-content">

        <form class="form-group" autocomplete="off" method="post">
            <label for="u_mail">Email Principale</label>
            <?php if($u_mail): ?>
                <span class="spanit status-private td-padding min-raduised blocked"><?= e($u_mail->email); ?></span>
            <?php endif; ?>
            <div class="margin-bottoms-zx"></div>
            <label for="u_status">Status</label>
            <select name="u_status" id="u_status" class="daf-form-ctrl minifierer inlined" required="required">
                <option class="td-padding" value="Private" <?= $u_mail->status == "Private" ? "selected" : ""; ?>>Privée</option>
                <option class="td-padding" value="Public" <?= $u_mail->status == "Public" ? "selected" : ""; ?>>Publique</option>
            </select>
            &nbsp;
            <input type="submit" name="set_mail_status_btn" value="Changer" class="td-set-btn min-raduised inlined" />
        </form>

    </div>

    <div class="divider"></div>

    <div class="td-content text-size-zx">

        <i class="fa fa-question fa-lg text-danger"></i>&nbsp;Seule votre adresse principale peut changer de statut.

    </div>

</div>
