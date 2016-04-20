<?php
/**
 * User: Yitzak DEKPEMOU
 */

//  Vérifie si une session à déjà été créer pour un utilisateur

if(isset($_SESSION['user_id']) && isset($_SESSION['pseudo'])) {

    header('Location:home.php');

    exit();

}

