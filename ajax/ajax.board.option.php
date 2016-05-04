<?php
session_start();
require "../config/database.php";
require "../includes/functions.php";
require "../includes/constants.php";
require "../filters/auth.filter.php";
?>
<?php if(isset($_POST['bid']) && is_numeric($_POST['bid'])): ?>

    <?php
    extract($_POST);
    $listes = find_in_table_by_external_key($bid, 'b_id', 'board_list', 'order by id asc');
    ?>

    <?php if($listes): ?>
        <?php foreach($listes as $liste): ?>
            <?php $notes = find_in_table_by_external_key($liste->id, 'bl_id', 'notes', 'and u_id="'.get_session('user_id').'" and archivate="'.'0"', 'order by id desc'); ?>
            <?php if($liste->archivate === "0"): ?>
                <div class="b-list-wrapper">
                    <div class="b-list-content board-list-content" id="js-list-note-container">
                        <div class="b-list-header u-clearfix" id="js-head-list">
                            <div class="b-list-head" id="js-list-header">
                                <div class="list-title bolder inlined" id="js-list-title" about="<?= $liste->title; ?>" accesskey="<?= $liste->id; ?>"><?= $liste->title ; ?></div>
                                <?php if($notes): ?>
                                    <div class="list-menu inlined float-right cur-to-point" id="js-list-menu">
                                        <i class="fa fa-angle-down text-size-lg"></i>
                                        <!-- -->
                                        <div class="list-sous-menu min-raduised" id="js-list-sub-menu" accesskey="<?= $liste->id; ?>">
                                            <span class="head-list-sous-menu">Actions</span>
                                            <span class="fcklink-list-sous-menu cur-to-point" id="js-add-note-listmenu">Ajouter une note</span>
                                            <span class="fcklink-list-sous-menu cur-to-point" id="js-archivate-thislist">Archiver cette liste</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                        <?php if($notes): ?>
                        <div class="note-containor" id="js-list-note">
                            <?php foreach($notes as $note): ?>
                                <?php if($note->archivate === "0"): ?>
                                    <div class="one-note min-raduised cur-to-point text-size-1x" style="background-color: <?= $note->background ?>"
                                         id="js-self-note" title="<?php e($note->id);?>">
                                        <span class="blocked margin-bottoms-zx">
                                            <?= str_word_count($note->note) > 10
                                                ? read_more(nl2br(e($note->note)), 10)."<a class='text-size-zx'>(Cliquer pour voir tout le texte)</a>"
                                                : nl2br(e($note->note)); ?>
                                        </span>
                                        <?php if($note->note_file && $note->note_file !== ''): ?>
                                            <span class="image-inside-note blocked margin-bottoms-zx">
                                                <img class="min-raduised" src="<?= $note->note_file; ?>">
                                            </span>
                                        <?php endif; ?>
                                        <?php
                                        $timestamp = new DateTime($note->created_at);
                                        $timestamp->getTimestamp();
                                        $timestamp = $timestamp->format('U');
                                        ?>
                                        <span class="inlined float-left" title="<?= e($note->description); ?>"><?= $note->description ? "<i class='fa fa-align-right fa-rotate-180'></i>&nbsp;|&nbsp;" : ""; ?></span>
                                        <span class="inlined float-left" title="Image disponible"><?= $note->note_file ? "<i class='fa fa-image fa-rotate-180'></i>&nbsp;|&nbsp; " : ""; ?></span>
                                        <span class="timeago inline text-size-zx"><?= set_time($timestamp); ?></span>
                                        <input type="hidden" name="js_note_hid" value="<?= e($note->id); ?>" />
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <div id="js-add-note">
                            <span class="b-note-adder td-color-grey cur-to-point align-left">Créer une note ...</span>
                            <div class="b-add-note" id="<?= $liste->id; ?>">
                                <textarea name="new_note_name" class="blocked min-raduised" id="js-add-note-input"
                                          placeholder="Créer une note"></textarea>
                                <input type="hidden" name="note_list_hid" id="js-list-hid" value="<?= e($liste->id); ?>" />
                                <span class="inlined td-color-grey float-left text-size-zx margin-bottoms-zx" id="js-infobox">
                                    - Taper ENTRER pour enregistrer votre note.
                                    <br />
                                    - Taper SHIFT+ENTRER pour les sauts de lignes.
                                </span>
                                <button type="reset" name="reset_note_adder" class="inlined reseter float-right margin-bottoms-zx" id="js-note-reseter"><i class="fa fa-close fa-1x"></i></button>
                                <div id="js-list-response" class="margin-top-zx margin-bottoms-zx">
                                    <i class="fa fa-times"></i>&nbsp;Impossible d'enregister cette note.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="b-list-wrapper">
        <div class="b-list-content">
            <div class="b-list-adder cur-to-point align-center min-raduised" id="js-list-adder">
                Créer une liste ...
            </div>

            <form class="b-add-list" id="js-add-list-form" autocomplete="off" method="post">
                <input type="text" name="new_list_name" class="blocked" id="js-add-list-input"
                       value="" placeholder="Créer une liste"
                />
                <button type="submit" name="new_liste_adder_btn" class="inlined td-set-btn min-raduised" id="js-list-submitter">Enregistrer</button>
                <button type="reset" name="reset_list_adder" class="inlined reseter" id="js-list-reseter"><i class="fa fa-close fa-1x"></i></button>
                <div id="js-list-response" class="margin-top-zx margin-bottoms-zx"></div>
            </form>
        </div>
    </div>

<?php endif; ?>
