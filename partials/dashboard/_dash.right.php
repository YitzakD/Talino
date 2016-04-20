<div class="td-title bgc-title">
    <span class="td-dash-right-title">
        <span class="td-dash-board">Vos tableaux</span>&nbsp;
        <span class="td-dash-notifier-bull"><?= $nboard>0 ? e($nboard) : '0'; ?></span>
    </span>
    <span class="td-dash-right-title-btn">
        <a href="new.board.php" class="td-dash-btn-primary"><i class="fa fa-plus"></i>&nbsp;Nouveau Tableau</a>
    </span>
</div>
<div class="td-dash-interlined">
    Ici, c'est la liste de vos tableau les plus visités.
</div>
<div class="td-content">
    <?php if($nboard > 0) : ?>
        <?php foreach($boards as $board): ?>
            <span class="td-dash-right-board-title">
                <?= get_table_icon($board->status); ?>
                <a href="board.php?b=<?= e($board->link); ?>" class="btn-link bolder"><?= e($user->pseudo.'/'.$board->title) ?></a>
            </span>
        <?php endforeach; ?>
        ...
        <?php if($nboard > $limit): ?>
            <a href="profile.php?id=<?= get_session('pseudo'); ?>&tab=boards" class="td-dash-right-seemore-btn">Voir tous les tableaux</a>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-warm td-dash-alert"><b>:(</b>&nbsp;&nbsp;Vous n'avez pas de tableaux pur le moment!</div>
    <?php endif; ?>
</div>