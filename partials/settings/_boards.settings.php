<div class="td-div bordered min-raduised">

    <div class="td-title bgc-title"><h3>Tableaux</h3></div>

    <?php if($boardscount > 0): ?>

        <?php foreach($boards as $board): ?>
            <div class="td-content">

                <div class="blocked">
                    <span class="inlined"><?= get_table_icon($board->status); ?></span>
                    <span class="inlined">
                        <?php if($board->archivate === "1"): ?>
                            <a href="allboards.php?id=<?= get_session('pseudo'); ?>&tab=closed#<?= e($board->link) ?>"
                               class="btn-link">
                                <?= e($board->title); ?>
                            </a>
                        <?php else: ?>
                            <a href="board.php?b=<?= $board->link; ?>"
                               class="btn-link">
                                <?= e($board->title); ?>
                            </a>
                        <?php endif; ?>
                    </span>
                    &nbsp;
                    <span class="inlined spanit set-nbr-notes min-raduised text-size-zx">
                        <?php $ncount = cell_count('notes', 'b_id', $board->id); ?>
                        <?= $ncount > 1 ? $ncount.'&nbsp;Notes' : $ncount.'&nbsp;Note'; ?>
                    </span>
                    &nbsp;
                    <span class="inlined text-size-zx">
                        <?php $board->created_at = date_to_fr(strftime("%d %b %Y", strtotime($board->created_at))); ?>
                        <?= $board->created_at ? '(Créer le '.e($board->created_at).')' : ''; ?>
                    </span>
                    <?php if($board->archivate === "1"): ?>
                        &nbsp;
                        <span class="inlined text-size-1x td-color-grey">
                            [Ce tableau est fermé}
                        </span>
                    <?php endif; ?>

                    <span class="inlined float-right text-size-lg">
                        <form  class="form-group inlined" action="settings.php?page=admin.boards&id=<?= get_session('pseudo'); ?>" method="post">
                            <input type="hidden" name="board_id_to_delete" value="<?= e($board->id); ?>">
                            <button type="submit" class="spanit btn-warm min-raduised" name="board_to_delete"><i class="fa fa-trash-o"></i></button>
                        </form>
                    </span>

                </div>


            </div>

            <div class="divider"></div>

        <?php endforeach; ?>

    <?php else: ?>
        <div class="td-content">

            <span class="blocked text-size-1x">
                Vous n'avez pas de Tableaux pour le moment.
            </span>

        </div>

        <div class="divider"></div>

    <?php endif; ?>

    <div class="td-content text-size-zx">

        <i class="fa fa-question fa-lg text-danger"></i>&nbsp;
        Vous voulez créer une nouveau tableau? Vous trouverez un formulaire sur la page de&nbsp;
        <a href="new.board.php" class="btn-link">création de tableaux</a>.

    </div>

</div>