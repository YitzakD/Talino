<div class="td-div bordered min-raduised"><!-- Box de Session -->

    <div class="td-title bgc-title"><h3>Session</h3></div>

    <div class="td-content">

        <div class="span-horizontal-group">

            <div class="span-in-left text-size-3x securi-left">

                <i class="fa fa-desktop fa-2x float-center"></i>

            </div>

            <div class="span-in-right securi-right">
                <div class="blocked">
                    <span class="bolder"><?= $secu->geoplugin_city." ".$ip; ?></span>
                    <br />
                    <span class="td-color-grey text-size-1x">Votre session actuelle</span>
                </div>

                <div class="blocked margin-top-zx">
                    <span class="bolder"><?= $navigateur; ?></span><span class="td-color-grey">&nbsp;sur <?= $osys; ?></span>
                </div>

                <div class="blocked margin-top-zx">
                    <span class="bolder">localisation</span>
                    <br />
                    <span class="td-color-grey text-size-1x">
                        <?= $secu->geoplugin_city.", ".$secu->geoplugin_regionName.", ".$secu->geoplugin_countryName; ?>
                    </span>
                </div>

                <div class="blocked margin-top-zx">
                    <span class="bolder">Incription</span>
                    <br />
                    <span class="td-color-grey text-size-1x">
                        <?php $user->created_at = date_to_fr(strftime("%d %b %Y", strtotime($user->created_at))); ?>
                        depuis le <?= e($user->created_at); ?>
                    </span>
                </div>
            </div>

        </div>

    </div>

</div>

<div class="td-div bordered min-raduised margin-top-1x">

    <div class="td-title bgc-title"><h3>Journal de sécurité</h3></div>


        <?php if($hstories): ?>
            <div class="td-content">

                <div class="blocked text-size-1x td-color-grey">
                    Ceci est un journal de sécurité des événements importants impliquant votre compte.
                </div>

            </div>

            <?php foreach($hstories as $hstory): ?>

                <div class="divider"></div>

                <div class="td-content text-size-1x">

                    <div class="inlined bolder"><?= $hstory->title; ?></div>

                    <div class="inlined">&nbsp;-&nbsp;<?= $hstory->description; ?></div>

                    <div class="inlined float-right">
                        <?php
                            $timestamp = new DateTime($hstory->created_at);
                            $timestamp->getTimestamp();
                            $timestamp = $timestamp->format('U');
                        ?>
                        <span class="timeago td-color-grey"><?= set_time($timestamp); ?></span>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>
            <div class="td-content">

                <div class="blocked text-size-1x">
                    // Journal de sécutité vide.
                </div>

            </div>
        <?php endif; ?>

</div>