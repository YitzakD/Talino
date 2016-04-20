<?php
/**
 * Created by PhpStorm.
 * User: Yitzak DEKPEMOU
 * Date: 16/03/2016
 * Time: 20:18
*/
?>


<?php if(isset($_SESSION['notification']['message'])) : ?>

    <div class="alert alert-<?= $_SESSION['notification']['type']; ?> td-pop bolder box-shadowed">
        <span class="fa fa-close float-right dot-close cur-to-point" id="js-dot-close"></span>

        <p><?= $_SESSION['notification']['message']; ?></p>

    </div>

    <?php $_SESSION['notification'] = []; ?>

<?php endif; ?>