<form class="form-group margin-top-1x" method="post">

    <label for="boardname">Nom du tableau<b class="text-danger">*</b></label>
    <input type="text"
           id="boardname" class="daf-form-ctrl minifierer" name="boardname"
           placeholder="ex., Todo" value="<?= get_input('boardname'); ?>"
           required="required" />
    <span class="nb-form-advice"><i class="fa fa-lightbulb-o fa-lg"></i>&nbsp;Les meilleurs noms de tableaux sont courts, donc facilement mémorisables.</span>

    <label for="boarddesc">Desciption (Optionnel)</label>
                <textarea id="boarddesc"
                          class="daf-form-ctrl" maxlength="140"
                          placeholder="ex., Confection d'un robot en JavaScript. (Optionnel)"
                          name="boarddesc"><?= get_input('boarddesc'); ?></textarea>

    <br />
    <div class="divider"></div>
    <br />

    <label for="boardacces">
        <input type="radio" id="boardacces" name="boardacces" value="Private" required="required" checked="checked" />
                    <span class="label-data-for-nb">
                        <span class="label-head"><i class="fa fa-lock fa-lg"></i>&nbsp;&nbsp;Privée</span>
                        <span class="label-cnt">.....&nbsp;&nbsp;&nbsp;Tableau personnel - Vous êtes la seule personne habilitée à y faire des modifications.</span>
                    </span>
    </label>

    <br />

    <label for="boardacces">
        <input type="radio" id="boardacces" name="boardacces" value="Public" disabled="disabled" />
                    <span class="label-data-for-nb">
                        <span class="label-head"><i class="fa fa-bookmark-o fa-lg"></i>&nbsp;&nbsp;Publique</span>
                        <span class="label-cnt">.....&nbsp;&nbsp;&nbsp;Tableau associative - Vous pouvez accorder des droits à d'autres utilisateurs
                            (<b class="text-danger">Cette fonctionnalité n'est pas encore disponible!</b>)</span>
                    </span>
    </label>

    <br />
    <div class="divider"></div>
    <br />

    <input type="submit" name="newboard_btn" class="form_input_validate" value="Créer un tableau" />

</form>