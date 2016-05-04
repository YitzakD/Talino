<?php
session_start();
require "../../../config/database.php";
require "../../../includes/functions.php";
require "../../../includes/constants.php";
require "../../../filters/auth.filter.php";
?>
<?php if(isset($_POST['bid']) && is_numeric($_POST['bid'])): ?>

    <?php
    extract($_POST);
    ?>

    <div class="td-content js-mb-menu-title" id="js-menu-one">
        <div class="mb-menu-title">
            <div class="blocked text-size-2x">
                <div class="inlined float-left align-center cur-to-point" id="js-close-opened" style="width: 40px;">
                    <i class="fa fa-arrow-left btn-link unerderlined"></i>
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="inlined float-left align-center" id="js-menu-title" style="width: auto">
                    Filtrage par couleurs
                </div>
            </div>
            <div class="divider"></div>
        </div>
    </div>

    <div class="td-content mb-menu-content" id="js-menu-box">
        <div class="mb-et-infos text-size-1x td-color-grey">
            <i class="fa fa-info"></i>
            <span>Il vous est possible de filtrer vos notes rien qu'en cliquant sur une couleur.</span>
        </div>

        <form class="mb-et-col margin-top-zx bolder" id="filterForm">

            <label for="js-eti-orange-colorbox" class="et-box orange margin-top-zx cur-to-point" accesskey="#FFAB4A">
                <input class="float-right" type="checkbox" name="background_color[]" value="#FFAB4A" id="js-eti-orange-colorbox"/>
            </label>

            <label for="js-eti-pink-colorbox" class="et-box pink margin-top-zx cur-to-point" accesskey="#F660AB">
                <input class="float-right" type="checkbox" name="background_color[]" value="#F660AB" id="js-eti-pink-colorbox"/>
            </label>

            <label for="js-eti-blue-colorbox" class="et-box blue margin-top-zx cur-to-point" accesskey="#00C2E0">
                <input class="float-right" type="checkbox" name="background_color[]" value="#00C2E0" id="js-eti-blue-colorbox"/>
            </label>

            <label for="js-eti-green-colorbox" class="et-box green margin-top-zx cur-to-point" accesskey="#51E898">
                <input class="float-right" type="checkbox" name="background_color[]" value="#51E898" id="js-eti-green-colorbox"/>
            </label>

            <label for="js-eti-yellow-colorbox" class="et-box yellow margin-top-zx cur-to-point" accesskey="#FFDB58">
                <input class="float-right" type="checkbox" name="background_color[]" value="#FFDB58" id="js-eti-yellow-colorbox"/>
            </label>

            <label for="js-eti-white-colorbox" class="et-box white margin-top-zx cur-to-point" accesskey="#F5F5F5">
                <input class="float-right" type="checkbox" name="background_color[]" value="#F5F5F5" id="js-eti-white-colorbox" />
            </label>

        </form>


    </div>

<?php endif; ?>

