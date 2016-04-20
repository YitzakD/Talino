<?php if($nboard > 0): ?>
<div class="daf-sct-1 td-col-min-big">
    <?php foreach($boards as $board): ?>
        <div class="board-infos bordered min-raduised">

            <div class="td-title bgc-title">
                <h3>
                    Activités
                    <span class="float-right">
                        <?= get_table_icon($board->status); ?>
                        <a href="board.php?b=<?= e($board->link) ?>"
                           class="btn-link bolder"><?= e($board->title); ?>
                        </a>
                    </span>
                </h3>
            </div>

            <div class="in-board-infos">

                <div class="in-board-desc text-size-2x">
                    <?= $board->description ? e($board->description) : "(Pas de description disponible.)"; ?>
                </div>

                <div class="p-u-tabs-svp">
                    <div class="span-in-top text-size-3x">Total 100</div>
                    <div class="span-in-bottom text-size-1x td-color-grey">Apports à ce tableau</div>
                </div>

                <div class="p-u-tabs-svp">
                    <div class="span-in-top text-size-3x">
                        <?php $blistcounter = cell_count('board_list', 'b_id', $board->id); ?>
                        <?= $blistcounter; ?>
                    </div>
                    <div class="span-in-bottom text-size-1x td-color-grey">Listes</div>
                </div>

                <div class="p-u-tabs-svp">
                    <div class="span-in-top text-size-3x">
                        <?php $notescounter = cell_count('notes', 'b_id', $board->id); ?>
                        <?= $notescounter; ?>
                    </div>
                    <div class="span-in-bottom text-size-1x td-color-grey">Notes</div>
                </div>

                <div class="p-u-tabs-svp">
                    <div class="span-in-top text-size-3x">
                        <?= $board->last_modif_date = date_to_fr(strftime("%d %b %y", strtotime($board->last_modif_date))); ?>
                    </div>
                    <div class="span-in-bottom text-size-1x td-color-grey">Dernière modification</div>
                </div>

            </div>

        </div>
    <?php endforeach; ?>
</div>
<div class="daf-gr-5 td-col-max-small popular-boards bordered min-raduised">
    <div class="td-title bgc-title"><h3><i class="fa fa-star-o"></i>&nbsp;Tableaux Populaires</h3></div>
    <?php foreach($populaires as $populaire): ?>
        <div class="p-pop-board">
            <div class="td-content">
                <div class="pop-board-name">
                    <?= get_table_icon($populaire->status); ?>
                    <a href="board.php?b=<?= e($board->link) ?>" class="btn-link bolder"><?= e($populaire->title); ?></a>
                </div>
                <div class="pop-board-desc text-size-1x">
                    <?= $populaire->description ? e($populaire->description) : "(Pas de description disponible.)"; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="daf-sct-1 td-col-max-big no-board-infos bordered min-raduised">
    <div class="td-title bgc-title"><h3>Activités</h3></div>
    <?php if($nboard < 1): ?>
        <div class="td-content no-board bolder unerderlined align-center text-in-shadowed">Vous n'aves pas de tableaux</div>
    <?php endif; ?>
</div>
<?php endif; ?>