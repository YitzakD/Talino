<?php
session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";
?>
<?php if(isset($_POST['bid']) && is_numeric($_POST['bid'])): ?>

    <?php
        extract($_POST);
        $board = find_table_by_id($bid);
    ?>
    <div class="td-content js-mb-menu-title" id="js-menu-one">
        <div class="mb-menu-title">
            <div class="blocked text-size-2x">
                <div class="inlined float-left align-center cur-to-point" id="js-close-opened" style="width: 40px;">
                    <i class="fa fa-arrow-left btn-link unerderlined"></i>
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="inlined float-left align-center" id="js-menu-title" style="width: auto">
                    Fond de tableau
                </div>
            </div>
            <div class="divider"></div>
        </div>
    </div>

    <div class="td-content mb-menu-content" id="js-menu-box">

        <label class="blocked margin-top-zx margin-bottoms-zx">Couleurs&nbsp;-&nbsp;
        <?php
            if($board->background === "#3498DB") {
                echo "<u>Bleu Todo</u>";
            } elseif($board->background === "#E74C3C") {
                echo "<u>Rouge Alzarin</u>";
            } elseif($board->background === "#2ECC71") {
                echo "<u>Vert Emeraude</u>";
            } elseif($board->background === "#9B59B6") {
                echo "<u>Violet Amethyst</u>";
            } elseif($board->background === "#34495E") {
                echo "<u>Bleu Alspahte</u>";
            } elseif($board->background === "#ECF0F1") {
                echo "<u>Blanc Grisonnant</u> (Par défaut)";
            } elseif($board->background === "#F1C40F") {
                echo "<u>Jaune Soleil</u>";
            } elseif($board->background === "#1ABC9C") {
                echo "<u>Vert Turquois</u>";
            } elseif($board->background === "#F39C12") {
                echo "<u>Orange Eléphant</u>";
            } else {
                echo "";
            }
        ?>
        </label>
        <div id="js-bc-picker" class="mb-bc-c-picker blocked">
            <div id="js-bc-picked" class="bgc-color-picker bgc-td-blue cur-to-point min-raduised <?= $board->background == '#3498DB' ? 'bgc-picked' : ''  ?>" accesskey="#3498DB"  title="Blue Todo">&nbsp;</div>
            <div id="js-bc-picked" class="bgc-color-picker bgc-fat-red cur-to-point min-raduised <?= $board->background == '#E74C3C' ? 'bgc-picked' : ''  ?>" accesskey="#E74C3C"  title="Rouge Alzarin">&nbsp;</div>
            <div id="js-bc-picked" class="bgc-color-picker bgc-fat-emerald cur-to-point min-raduised <?= $board->background == '#2ECC71' ? 'bgc-picked' : ''  ?>" accesskey="#2ECC71"  title="Vert Emeraude">&nbsp;</div>
        </div>
        <div id="js-bc-picker" class="mb-bc-c-picker blocked">
            <div id="js-bc-picked" class="bgc-color-picker bgc-fat-violet cur-to-point min-raduised <?= $board->background == '#9B59B6' ? 'bgc-picked' : ''  ?>" accesskey="#9B59B6"  title="Violet Amethyst">&nbsp;</div>
            <div id="js-bc-picked" class="bgc-color-picker bgc-fat-grey cur-to-point min-raduised <?= $board->background == '#34495E' ? 'bgc-picked' : ''  ?>" accesskey="#34495E"  title="Bleu Asphalte">&nbsp;</div>
            <div id="js-bc-picked" class="bgc-color-picker bgc-fat-yellow cur-to-point min-raduised <?= $board->background == '#F1C40F' ? 'bgc-picked' : ''  ?>" accesskey="#F1C40F"  title="Jaune Soleil">&nbsp;</div>
        </div>
        <div id="js-bc-picker" class="mb-bc-c-picker blocked">
            <div id="js-bc-picked" class="bgc-color-picker bgc-fat-orange cur-to-point min-raduised <?= $board->background == '#F39C12' ? 'bgc-picked' : ''  ?>" accesskey="#F39C12"  title="Orange Eléphant">&nbsp;</div>
            <div id="js-bc-picked" class="bgc-color-picker bgc-fat-white cur-to-point min-raduised <?= $board->background == '#ECF0F1' ? 'bgc-picked' : ''  ?>" accesskey="#ECF0F1"  title="Blanc Grisonnant">&nbsp;</div>
            <div id="js-bc-picked" class="bgc-color-picker bgc-fat-turquoise cur-to-point min-raduised <?= $board->background == '#1ABC9C' ? 'bgc-picked' : ''  ?>" accesskey="#1ABC9C"  title="Vert Turquois">&nbsp;</div>
        </div>

        <div class="divider margin-top-1x"></div>

        <label class="blocked margin-top-zx margin-bottoms-zx">Photos (Bientôt disponibles)</label>
        <!--
        <div id="js-bc-picker" class="mb-bc-c-picker blocked"></div>
        <div id="js-bc-picker" class="mb-bc-c-picker blocked"></div>
        <div id="js-bc-picker" class="mb-bc-c-picker blocked"></div>
        -->

        <div class="divider margin-top-1x"></div>

        <label class="blocked margin-top-zx margin-bottoms-zx">Textures (Bientôt disponibles)</label>
        <!--
        <div id="js-bc-picker" class="mb-bc-c-picker blocked"></div>
        <div id="js-bc-picker" class="mb-bc-c-picker blocked"></div>
        <div id="js-bc-picker" class="mb-bc-c-picker blocked"></div>
        -->

        <div class="clearer"></div>

        <div class="margin-top-1x margin-bottom-2x invisible">
            loremm ipsum
        </div>

    </div>

<?php endif; ?>

