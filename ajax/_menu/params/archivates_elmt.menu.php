<?php
session_start();
require "../../../config/database.php";
require "../../../includes/functions.php";
require "../../../includes/constants.php";
require "../../../filters/auth.filter.php";
?>
<?php if(isset($_POST['bid']) && is_numeric($_POST['bid'])): ?>

    <?php
    extract($_POST);
    $notes = find_in_table_by_external_key($bid, 'b_id', 'notes', 'and archivate="'.'1" and u_id="'.get_session('user_id').'"', 'order by id asc');
    $listes = find_in_table_by_external_key($bid, 'b_id', 'board_list', 'and archivate="'.'1" and u_id="'.get_session('user_id').'"', 'order by id asc');
    ?>

    <div class="td-content js-mb-menu-title" id="js-menu-one">
        <div class="mb-menu-title">
            <div class="blocked text-size-2x">
                <div class="inlined float-left align-center cur-to-point" id="js-close-opened" style="width: 40px;">
                    <i class="fa fa-arrow-left btn-link unerderlined"></i>
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="inlined float-left align-center" id="js-menu-title" style="width: auto">
                    Eléments archivés
                </div>
            </div>
            <div class="divider"></div>
        </div>
    </div>

    <div class="td-content mb-menu-content" id="js-menu-box">
        <div class="tabs-wrap">
            <ul class="tabs" id="archsHeader">
                <li>
                    <input type="radio" checked name="pma_tabs" id="js-archived-notes-pm" />
                    <label for="js-archived-notes-pm" name="pma_tabs" class="inlined archivs-pma float-left" id="js-note-archs">
                        <b class="btn-link cur-to-point">notes archivés</b>
                    </label>
                </li>
                <li>
                    <input type="radio" name="pma_tabs" id="js-archived-list-pm" />
                    <label for="js-archived-list-pm" name="pma_tabs" class="inlined archivs-pma float-right" id="js-list-archs">
                        <b class="btn-link cur-to-point">Listes archivés</b>
                    </label>
                </li>
            </ul>

            <div class="tabs-content" id="js-archived-content">
                <div id="js-archived-notes-pm">
                <?php if($notes): ?>
                    <div class="note-containor">
                        <?php foreach($notes as $note): ?>
                            <div class="pma-archived-box blocked margin-bottom-lg">
                                <div class="one-archived-note min-raduised text-size-1x">
                                    <span class="one-archived-note-bgc inlined float-right min-raduised cur-to-point" style="background-color: <?= $note->background; ?>" title="Couleur de la note"></span>
                                    <span class="blocked margin-bottoms-zx">
                                        <?= str_word_count($note->note) > 40
                                            ? read_more(nl2br(e($note->note)), 40)."<a class='text-size-zx'>(Cliquer pour voir tout le texte)</a>"
                                            : nl2br(e($note->note)); ?>
                                    </span>
                                    <?php
                                    $timestamp = new DateTime($note->created_at);
                                    $timestamp->getTimestamp();
                                    $timestamp = $timestamp->format('U');
                                    ?>
                                    <span title="<?= e($note->description); ?>"><?= $note->description ? "<i class='fa fa-align-right fa-rotate-180'></i>&nbsp;" : ""; ?></span>
                                    <span class="timeago inline text-size-zx"><?= set_time($timestamp); ?></span>
                                    <input type="hidden" name="js_note_hid" value="<?= e($note->id); ?>" />
                                </div>
                                <span class="clearer"></span>
                                <div class="inlined float-right" id="js-archivedNote-subMenu">
                                    <span class="btn-link td-color-grey cur-to-point"
                                          id="js-pma-noteRestaure"
                                          accesskey="<?= e($note->id); ?>">Restaurer</span>&nbsp;-&nbsp;
                                    <span class="btn-link td-color-grey cur-to-point"
                                          id="js-pma-noteDelete"
                                          accesskey="<?= e($note->id); ?>">Supprimer</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="td-color-grey text-size-2x bolder align-center">Vous n'avez pas de notes archivées.</p>
                <?php endif; ?>
                </div>

                <div id="js-archived-list-pm">
                    <?php if($listes): ?>
                        <div class="note-containor">
                            <?php foreach($listes as $liste): ?>
                                <div class="pma-archived-box blocked margin-bottoms-1x">
                                    <div class="one-archived-style min-raduised text-size-lg">
                                        <?= e($liste->title); ?>
                                    </div>
                                    <span class="clearer"></span>
                                    <div class="inlined float-right" id="js-archivedListe-subMenu">
                                        <span class=" td-set-btn min-raduised cur-to-point"
                                              id="js-pma-ListRestaure"
                                              accesskey="<?= e($liste->id); ?>">
                                            <i class="fa fa-refresh"></i>&nbsp;Restaurer
                                        </span>
                                    </div>
                                </div>
                                <div class="divider margin-bottom-lg"></div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="td-color-grey text-size-2x bolder align-center">Vous n'avez pas de listes archivées.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

<?php endif; ?>

