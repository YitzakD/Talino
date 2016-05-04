<div class="tabs-wrap blocked float-left">

    <ul class="tabs">

        <li>

            <input type="radio" <?= isset($_GET['tab']) && $_GET['tab'] === "stared" ? 'checked="checked"' : ""; ?> name="stared_tabs" id="stared" class="tab-hidden-radio" />

            <label for="stared">
                <a href="allboards.php?id=<?= get_session('pseudo'); ?>&tab=stared"
                   class="btn-link bolder">
                    <i class="fa fa-star"></i>&nbsp;Tableaux populaires
                </a>
            </label>

        </li>

        <li>

            <input type="radio" <?= isset($_GET['tab']) && $_GET['tab'] === "closed" ? 'checked="checked"' : ""; ?> name="closed_tabs" id="closed" class="tab-hidden-radio" />

            <label for="closed">
                <a href="allboards.php?id=<?= get_session('pseudo'); ?>&tab=closed"
                   class="btn-link bolder">
                    <i class="fa fa-power-off"></i>&nbsp;Tableaux fermés
                </a>
            </label>

        </li>

    </ul>

    <div class="tabs-content">
        <?php
            if(isset($_GET['tab']) && $_GET['tab'] === "closed") {

                require "partials/allboards/_all_closed_boards_tab.php";

            }else {

                require "partials/allboards/_all_stared_boards_tab.php";

            }
        ?>
    </div>

</div>