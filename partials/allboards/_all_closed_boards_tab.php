<?php if($closed): ?>
    <?php foreach($closed as $close): ?>
        <?php $activities = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'activities_story', 'and b_id="'.$close->id.'"', 'limit 7'); ?>
        <div class="board-infos bordered min-raduised">

            <div class="td-title bgc-title" id="<?= e($close->link); ?>">
                <h3>
                    <i class="fa fa-power-off"></i>
                    Tableau /
                    <span>
                        <span class="bolder td-color-grey"><?= e($close->title); ?>
                        </span>
                    </span>
                </h3>
            </div>

            <div class="in-board-infos">

                <div class="in-board-desc">
                    <div class="td-content text-size-1x td-color-grey">
                        <?= $close->description ? e($close->description) : "(Pas de description disponible.)"; ?>
                    </div>

                    <form action="allboards.php?id=<?= get_session('pseudo'); ?>&tab=closed" method="post" class="float-right margin-top-zx margin-bottoms-zx margin-right-zx">
                        <button name="re_open_board_btn"
                                class="td-set-btn min-raduised">
                            <i class="fa fa-refresh"></i>&nbsp;Ré-ouvrir
                        </button>
                        <input type="hidden" name="closedBoardHiddenID" value="<?= e($close->id); ?>"  />
                    </form>

                </div>

                <div class="p-u-tabs-svp td-color-grey">
                    <div class="span-in-top">Au total&nbsp;&nbsp;
                        <span class="text-size-3x text-danger"><?= e($close->contributions); ?></span>
                    </div>
                    <div class="span-in-bottom text-size-1x">Apports à ce tableau</div>
                </div>

                <div class="p-u-tabs-svp td-color-grey">
                    <div class="span-in-top text-size-3x">
                        <?php $blistcounter = cell_count('board_list', 'b_id', $close->id); ?>
                        <?= $blistcounter; ?>
                    </div>
                    <div class="span-in-bottom text-size-1x">Listes</div>
                </div>

                <div class="p-u-tabs-svp td-color-grey">
                    <div class="span-in-top text-size-3x">
                        <?php $notescounter = cell_count('notes', 'b_id', $close->id); ?>
                        <?= $notescounter; ?>
                    </div>
                    <div class="span-in-bottom text-size-1x">Notes</div>
                </div>

                <div class="p-u-tabs-svp td-color-grey">
                    <div class="span-in-top text-size-3x">
                        <?= $close->last_modif_date = date_to_fr(strftime("%d %b %y", strtotime($close->last_modif_date))); ?>
                    </div>
                    <div class="span-in-bottom text-size-1x">Dernière modification</div>
                </div>

            </div>

        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="td-col-max-big no-board-infos bordered min-raduised">
        <div class="td-title bgc-title"><h3><i class="fa fa-power-off"></i>&nbsp;Tableaux</h3></div>
        <?php if($nclosed < 1): ?>
            <div class="td-content no-board bolder unerderlined align-center text-in-shadowed">Vous n'aves pas de tableaux fermés.</div>
        <?php endif; ?>
    </div>
<?php endif; ?>