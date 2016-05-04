<div class="td-col-min-big inlined float-left">
    <div id="js-load-activities-in-profile" accesskey="<?= get_session('user_id') ?>">

    </div>
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
</div>