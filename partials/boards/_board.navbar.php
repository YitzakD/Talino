<div class="b-menu-bar no-margin">

    <div class="board-navbar">
        <div class="board-dropdown inlined">
            <span class="b-dropbtn">
                <?= $board->title; ?>&nbsp;&nbsp;<i class="fa fa-angle-down td-color-grey"></i>&nbsp;
            </span>
            <div class="b-dropdown-content">
                <?php foreach ($uboards as $uboard):  ?>
                    <a class="dd-tb" href="board.php?b=<?= e($uboard->link); ?>">
                        <h4><?= get_table_icon(e($uboard->status)); ?>&nbsp;<?= e($uboard->title); ?></h4>
                        <p><?= e($uboard->description); ?></p>
                    </a>
                <?php endforeach; ?>
                <?php if($boardscounter > 3): ?>
                    <a href="#" class="btn-link">Voire tous les tableaux</a>
                <?php endif;  ?>
                <a href="new.board.php" class="btn-link">Créer un nouveau tableau</a>
            </div>
        </div>
        <div class="board-dropdown inlined float-right" id="js-board-menu">
            <span class="b-menu-acces nav-toggler toggle-push-right cur-to-point"
                  title="Ouvrir le menu"
                  id="js-open-menu">
                <i class="fa fa-navicon"></i>&nbsp;MENU
            </span>
        </div>
    </div>

</div>
