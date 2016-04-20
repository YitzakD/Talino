<?php
/**
 * User: Yitzak DEKPEMOU
*/

//  Vérifie si une session à déjà été créer pour un utilisateur

if(!isset($_SESSION['user_id']) || !isset($_SESSION['pseudo'])) {
    
    $_SESSION['fowarding_url'] = $_SERVER['REQUEST_URI'];

    header('Location:home.php');

    exit();

}
