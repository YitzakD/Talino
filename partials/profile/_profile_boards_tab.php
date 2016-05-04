<?php if($nboard > 0): ?>
<div class="td-col-min-big inlined float-left">
    <?php foreach($boards as $board): ?>
    <div class="board-infos bordered min-raduised">

        <div class="td-title bgc-title">
            <h3>
                <?= get_table_icon($board->status); ?>
                Activités /
            <span>
                <a href="board.php?b=<?= e($board->link) ?>"
                   class="btn-link bolder"><?= e($board->title); ?>
                </a>
            </span>
            </h3>
        </div>

        <div class="in-board-infos">

            <div class="in-board-desc text-size-lg">
                <div class="td-content td-color-grey">
                    <?= $board->description ? e($board->description) : "(Pas de description disponible.)"; ?>
                </div>
            </div>

            <div class="p-u-tabs-svp">
                <div class="span-in-top text-size-3x">Total&nbsp;<?= $board->contributions ? e($board->contributions) : "0"; ?></div>
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
<div class="td-col-max-small inlined float-right">
    <div class="popular-boards bordered min-raduised">
        <div class="td-title bgc-title"><h3><i class="fa fa-star-o"></i>&nbsp;Tableaux Populaires&nbsp;(150+ A)</h3></div>
        <?php foreach($populaires as $populaire): ?>
            <div class="p-pop-board">
                <div class="td-content">
                    <div class="pop-board-name">
                        <?= get_table_icon($populaire->status); ?>
                        <a href="board.php?b=<?= e($board->link) ?>" class="btn-link bolder"><?= e($populaire->title); ?></a>
                    </div>
                    <div class="pop-board-desc text-size-1x">
                        <?= $populaire->description ? read_more(e($populaire->description), 10) : "(Pas de description disponible.)"; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="p-pop-board">
            <div class="td-content">
                <div class="pop-board-name margin-bottoms-zx align-center">
                    <a href="allboards.php?id=<?= get_session('pseudo'); ?>&tab=stared" class="btn-link bolder">Voir tous les tableaux populaires.</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="closed-boards bordered min-raduised">
        <div class="td-title bgc-title"><h3><i class="fa fa-power-off"></i>&nbsp;Tableaux Fermés</h3></div>
        <?php foreach($closed as $close): ?>
            <div class="p-pop-board">
                <div class="td-content">
                    <div class="pop-board-name">
                        <?= get_table_icon($close->status); ?>
                        <a href="allboards.php?id=<?= get_session('pseudo'); ?>&tab=closed#<?= e($close->link) ?>" class="btn-link bolder"><?= e($close->title); ?></a>
                    </div>
                    <div class="pop-board-desc text-size-1x">
                        <?= $close->description ? read_more(e($close->description), 10) : "(Pas de description disponible.)"; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="p-pop-board">
            <div class="td-content">
                <div class="pop-board-name margin-bottoms-zx align-center">
                    <a href="allboards.php?id=<?= get_session('pseudo'); ?>&tab=closed" class="btn-link bolder">Voir tous les tableaux fermés.</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php elseif($ncboard > 0): ?>
<div class="td-col-min-big no-opened-board-infos min-raduised bordered inlined float-left">
    <div class="td-title bgc-title"><h3>Activités</h3></div>
    <div class="td-content no-board bolder unerderlined align-center text-in-shadowed">Vous n'aves pas de tableaux ouverts</div>
</div>
<div class="td-col-max-small inlined float-right">

    <div class="closed-boards bordered min-raduised">
        <div class="td-title bgc-title"><h3><i class="fa fa-power-off"></i>&nbsp;Tableaux Fermés</h3></div>
        <?php foreach($closed as $close): ?>
            <div class="p-pop-board">
                <div class="td-content">
                    <div class="pop-board-name">
                        <?= get_table_icon($close->status); ?>
                        <a href="allboards.php?id=<?= get_session('pseudo'); ?>&tab=closed#<?= e($close->link) ?>" class="btn-link bolder"><?= e($close->title); ?></a>
                    </div>
                    <div class="pop-board-desc text-size-1x">
                        <?= $close->description ? read_more(e($close->description), 10) : "(Pas de description disponible.)"; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="p-pop-board">
            <div class="td-content">
                <div class="pop-board-name margin-bottoms-zx align-center">
                    <a href="allboards.php?id=<?= get_session('pseudo'); ?>&tab=closed" class="btn-link bolder">Voir tous les tableaux fermés.</a>
                </div>
            </div>
        </div>
    </div>

</div>
<?php else: ?>
<div class="td-col-max-big no-board-infos bordered min-raduised">
    <div class="td-title bgc-title"><h3>Activités</h3></div>
    <?php if($nboard < 1): ?>
        <div class="td-content no-board bolder unerderlined align-center text-in-shadowed">Vous n'aves pas de tableaux</div>
    <?php endif; ?>
</div>
<?php endif; ?>