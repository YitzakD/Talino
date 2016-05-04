<?php if($stared): ?>
    <?php foreach($stared as $star): ?>
        <?php $activities = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'activities_story', 'and b_id="'.$star->id.'"', 'order by id desc limit 3'); ?>
        <div class="board-infos bordered min-raduised">

            <div class="td-title bgc-title">
                <h3>
                    <?= get_table_icon($star->status); ?>
                    Tableau /
                <span>
                    <a href="board.php?b=<?= e($star->link) ?>"
                       class="btn-link bolder"><?= e($star->title); ?>
                    </a>
                </span>
                </h3>
            </div>

            <div class="in-board-infos">

                <div class="in-board-desc">
                    <div class="td-content text-size-1x td-color-grey">
                        <?= $star->description ? e($star->description) : "(Pas de description disponible.)"; ?>
                    </div>
                </div>


                <div class="clearer"></div>

                <div class="in-board-desc">
                    <div class="td-content">
                        <?php foreach($activities as $activity): ?>
                            <div class="td-col-max-big  margin-bottoms-zx blocked float-left">
                                <div>
                                    <?= '<b>'.get_session('pseudo').'</b>&nbsp;'.e($activity->description); ?>
                                    <?php
                                    $timestamp = new DateTime($activity->created_at);
                                    $timestamp->getTimestamp();
                                    $timestamp = $timestamp->format('U');
                                    ?>
                                    <span class="timeago text-size-zx td-color-grey"><?= set_time($timestamp); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="p-u-tabs-svp">
                    <div class="span-in-top">Au total&nbsp;&nbsp;
                        <span class="text-size-3x td-color-ld"><?= e($star->contributions); ?></span>
                    </div>
                    <div class="span-in-bottom text-size-1x td-color-grey">Apports à ce tableau</div>
                </div>

                <div class="p-u-tabs-svp">
                    <div class="span-in-top text-size-3x">
                        <?php $blistcounter = cell_count('board_list', 'b_id', $star->id); ?>
                        <?= $blistcounter; ?>
                    </div>
                    <div class="span-in-bottom text-size-1x td-color-grey">Listes</div>
                </div>

                <div class="p-u-tabs-svp">
                    <div class="span-in-top text-size-3x">
                        <?php $notescounter = cell_count('notes', 'b_id', $star->id); ?>
                        <?= $notescounter; ?>
                    </div>
                    <div class="span-in-bottom text-size-1x td-color-grey">Notes</div>
                </div>

                <div class="p-u-tabs-svp">
                    <div class="span-in-top text-size-3x">
                        <?= $star->last_modif_date = date_to_fr(strftime("%d %b %y", strtotime($star->last_modif_date))); ?>
                    </div>
                    <div class="span-in-bottom text-size-1x td-color-grey">Dernière modification</div>
                </div>

            </div>

        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="td-col-max-big no-board-infos bordered min-raduised">
        <div class="td-title bgc-title"><h3><i class="fa fa-star"></i>&nbsp;Tableaux</h3></div>
        <?php if($nstared < 1): ?>
            <div class="td-content no-board align-center text-in-shadowed">
                <div class="bolder unerderlined ">
                    Vous n'aves pas de tableaux populaires.
                </div>
            </div>
            <div class="text-size-1x align-center td-bgc-ld td-content blanco bolder">
                <i class="fa fa-info fa-lg"></i>&nbsp;&nbsp;Vous devez faire plus de 50 apports dans un tableau pour que celui-ci soit considérer comme populaire.
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>