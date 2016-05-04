<div class="tabs-wrap">

    <ul class="tabs">

        <li>

            <input type="radio" checked name="profile_tabs" id="myactivities" class="tab-hidden-radio" />

            <label for="myactivities">
                <a href="profile.php?id=<?= get_session('pseudo') ?>"
                   class="btn-link bolder">
                    <i class="fa fa-align-left"></i>&nbsp;&nbsp;
                    Fil d'activités
                </a>
            </label>

        </li>

        <li>

            <input type="radio" <?= $checked; ?> name="profile_tabs" id="mybaords" class="tab-hidden-radio" />

            <label for="mybaords">
                <a href="profile.php?id=<?= get_session('pseudo').'&tab=boards' ?>"
                   class="btn-link bolder">
                    <i class="fa fa-columns"></i>&nbsp;&nbsp;
                    Tableaux
                </a>
            </label>

        </li>

        <li class=" float-right">

            <a href="settings.php?page=profile&id=<?= get_session('pseudo'); ?>"
               class="btn td-bgc-lg text-size-zx p-to-edit">
                <i class="fa fa-pencil"></i>&nbsp;Modifier&nbsp;mon&nbsp;profile
            </a>

        </li>

    </ul>

    <div class="tabs-content">
        <?php
            if(isset($_GET['tab']) && $_GET['tab'] === "boards") {
                require "partials/profile/_profile_boards_tab.php";
            } else {
                require "partials/profile/_profile_activities_tab.php";
            }
        ?>
    </div>

</div>