<?php
session_start();
require "../config/database.php";
require "../includes/functions.php";
require "../includes/constants.php";
require "../filters/auth.filter.php";
?>
<?php if(isset($_POST['note_id']) && is_numeric($_POST['note_id'])): ?>

    <?php
        extract($_POST);

        $mainFolder = 'assets/uploads/notes/'.get_session('pseudo').'/';

        $q = $db->prepare("SELECT notes.*,
                           board_list.title
                           FROM notes
                           LEFT JOIN board_list
                           ON board_list.id = notes.bl_id
                           WHERE notes.id=:id AND notes.u_id=:u_id");

        $q->execute([
            'id' => $note_id,
            'u_id' => get_session('user_id')
        ]);

        $count = $q->rowCount();

        $note = $q->fetch(PDO::FETCH_OBJ);

        $listes = find_in_table_by_external_key($note->b_id, 'b_id', 'board_list', 'order by id asc');

        //  var_dump($listes);
    ?>

    <?php if($count): ?>
    <div class="td-content">
        <div class="alert alert-succes cur-to-point" id="js-pop-alert-succes">
            <div class="blocked blanco">
                <i class="fa fa-check inlined"></i>
                <span class="inlined bolder">
                   &nbsp; Modification enregistrée
                </span>
                <i class="fa fa-close blocked float-right" style="margin-right: 20px"></i>
            </div>
        </div>
        <div class="alert alert-danger cur-to-point" id="js-pop-alert-errors">
            <div class="blocked blanco">
                <i class="fa fa-times inlined"></i>
                <span class="inlined bolder">
                    &nbsp;Modification échouée
                </span>
                <i class="fa fa-close blocked float-right" style="margin-right: 20px"></i>
            </div>
        </div>


        <div class="changed-background">
            <span class="blocked margin-bottoms-zx"><i class="fa fa-quote-left"></i></span>

            <div>
                <i class="pin"></i>
                <div class="push-edit-note min-raduised" title="Cliquer dessus pour modifier la note"
                     id="js-editable-block-note"><?= e(nl2br($note->note)); ?></div>
            </div>

            <span class="blocked align-right margin-bottoms-zx margin-top-zx"><i class="fa fa-quote-right"></i></span>

            <?php
                $timestamp = new DateTime($note->created_at);
                $timestamp->getTimestamp();
                $timestamp = $timestamp->format('U');
            ?>
            <div class="blocked">Dans la liste: <u><?= $note->title; ?></u> -
                <span class="timeago text-size-zx td-color-grey"><?= set_time($timestamp); ?></span>
            </div>
        </div>

        <label for="note_description" class="blocked margin-top-zx"><i class="fa fa-align-left"></i>&nbsp;&nbsp;Description</label>
        <div class="push-edit-desc min-raduised" title="Cliquer dessus pour modifier la description"
             id="js-editable-block-desc"><?= $note->description ? e(nl2br($note->description)) : "Cliquer sur le texte pour décrire cette note."; ?></div>

        <div class="divider margin-top-zx margin-bottoms-zx"></div>

        <?php if($note->note_file !==''): ?>
            <div class="note-image-file min-raduised">
                <div class="note-img-in-action float-left align-center">
                    <span class="note-img-action js-view-nif min-raduised" title="Voir l'image">&nbsp;<i class="fa fa-eye bolder"></i>&nbsp;</span>
                    <span class="note-img-action js-sup-nif min-raduised" title="Supprimer l'image">&nbsp;<i class="fa fa-trash-o bolder"></i>&nbsp;</span>
                </div>
                <img class="min-raduised" src="<?= $note->note_file; ?>" accesskey="<?= $note->note_file; ?>" />
            </div>
        <?php else : ?>
            <?php foreach(glob($mainFolder.'*') as $file): ?>
                <div class="min-raduised align-center td-color-grey text-size-zx margin-top-zx" id="dropzone"
                     data-value="<?= end(explode('/', $file)) ?>" data-folder="<?= $mainFolder; ?>">
                    <img src="<?= $file; ?>" />
                </div>
            <?php endforeach; ?>
            <div class="dropzone min-raduised align-center td-color-grey text-size-zx" id="dropzone"></div>
        <?php endif; ?>

        <div class="divider margin-top-zx"></div>

        <label class="blocked margin-top-zx">Choisir une couleur de fond</label>
        <div id="js-picker" class="text-size-zx align-center valign-middle">
            <div id="js-pick-color" class="pick-color orange cur-to-point min-raduised <?= $note->background == '#FFAB4A' ? 'picked-color' : ''  ?>" accesskey="#FFAB4A" title="Orange">&nbsp;</div>
            <div id="js-pick-color" class="pick-color pink cur-to-point min-raduised <?= $note->background == '#F660AB' ? 'picked-color' : ''  ?>" accesskey="#F660AB"  title="Rose">&nbsp;</div>
            <div id="js-pick-color" class="pick-color blue cur-to-point min-raduised <?= $note->background == '#00C2E0' ? 'picked-color' : ''  ?>" accesskey="#00C2E0" title="Bleu">&nbsp;</div>
            <div id="js-pick-color" class="pick-color green cur-to-point min-raduised <?= $note->background == '#51E898' ? 'picked-color' : ''  ?>" accesskey="#51E898" title="Vert">&nbsp;</div>
            <div id="js-pick-color" class="pick-color yellow cur-to-point min-raduised <?= $note->background == '#FFDB58' ? 'picked-color' : ''  ?>" accesskey="#FFDB58" title="Jaune">&nbsp;</div>
            <div id="js-pick-color" class="pick-color grey cur-to-point min-raduised <?= $note->background == '#F5F5F5' ? 'picked-color' : ''  ?>" accesskey="#F5F5F5" title="Couleur par défaut">&nbsp;</div>
            <!-- -->
        </div>
        <div class="blocked td-color-grey text-size-1x margin-top-zx">
            Couleur actuelle -
            <?php
                if($note->background === "#FFAB4A") {
                    echo "<u>Orange</u>";
                } elseif($note->background === "#F660AB") {
                    echo "<u>Rose</u>";
                } elseif($note->background === "#00C2E0") {
                    echo "<u>Bleu</u>";
                } elseif($note->background === "#51E898") {
                    echo "<u>Vert</u>";
                }  elseif($note->background === "#FFDB58") {
                    echo "<u>Jaune</u>";
                } else {
                    echo "<u>Gris</u> (Par défaut)";
                }
            ?>
        </div>

        <div class="divider margin-top-zx"></div>

        <label class="blocked margin-top-zx">Déplacer vers</label>
        <select class="daf-form-ctrl" id="js-select-move-note">
            <?php foreach($listes as $liste): ?>
                <option value="<?= $liste->id; ?>" <?= $liste->id === $note->bl_id ? "selected disabled" : ""; ?>>
                    <?= e($liste->title); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="blocked margin-top-zx">Copier vers</label>
        <select class="daf-form-ctrl" id="js-select-copy-note">
            <option>Choisir parmis mes listes</option>
            <?php foreach($listes as $liste): ?>
                <option value="<?= $liste->id; ?>" <?= $liste->id === $note->bl_id ? "disabled" : ""; ?>>
                    <?= e($liste->title); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="divider margin-top-zx"></div>

        <div class="btn btn-warm cur-to-point margin-top-zx float-right" id="js-note-archiver-btn" accesskey="<?= $note->id ?>">
            <i class="fa fa-archive"></i>&nbsp;&nbsp;Archiver
        </div>

        <div class="alert alert-info cur-to-point margin-top-zx margin-bottom-lg"  style="width: 89%" id="js-pop-alert-infos">
            <div class="blocked blanco text-size-1x">
                <i class="fa fa-lightbulb-o inlined"></i>
                <span class="inlined bolder">
                    &nbsp;Cliquer sur les textes pour les modifier.
                </span>
            </div>
        </div>
    </div>
    <?php else: ?>

        <div class='alert alert-danger set-alert-in-block blanco blocked margin-bottoms-zx' style='width: 89%'>
            Impossible de trouver cette note!<br />
            Raison: Le système n'a pas reconu l'identifiant de la note.<br/>
            Solution: Recharger la page en cliquant sur le lien ci-dessous.
        </div>
        <a href='' class='blocked btn-link margin-top-zx'><i class='fa fa-spinner fa-spin'></i>&nbsp;Recharger la page</a>

    <?php endif; ?>

<?php else: ?>

    <div class='alert alert-danger set-alert-in-block blanco blocked margin-bottoms-zx' style='width: 89%'>
        Impossible de trouver cette note!<br />
        Raison: Le système n'a pas reconu l'identifiant de la note.<br/>
        Solution: Recharger la page en cliquant sur le lien ci-dessous.
    </div>
    <a href='' class='blocked btn-link margin-top-zx'><i class='fa fa-spinner fa-spin'></i>&nbsp;Recharger la page</a>

<?php endif; ?>

