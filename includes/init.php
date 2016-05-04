<?php
/**
 * User: Yitzak DEKPEMOU
*/

require('bootstrap/locale.php');
require('config/database.php');
require('includes/functions.php');
require('includes/constants.php');
require('includes/classes/images.class.php');

if(!empty($_COOKIE['pseudo']) && !empty($_COOKIE['user_id'])) {

    $_SESSION['pseudo'] = $_COOKIE['pseudo'];

    $_SESSION['user_id'] = $_COOKIE['user_id'];

}

auto_login();