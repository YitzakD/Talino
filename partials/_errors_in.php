<?php
/**
 * Created by PhpStorm.
 * User: Yitzak DEKPEMOU
 * Date: 16/03/2016
 * Time: 19:58
*/

// Gère les pop-ups d'erreurs
if(isset($errors) && count($errors) != 0) {

    echo '<div class="alert alert-danger td-pop-in">
            <span class="fa fa-close float-right dot-close cur-to-point" id="js-dot-close"></span>';

    foreach($errors  as $error){

        echo $error . '<br />';

    }

    echo '</div>';

}