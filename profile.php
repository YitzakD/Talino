<?php
/**
 * User: Yitzak DEKPEMOU
 */

//  SESSION START
session_start();
//  Insertion des needed.
require "includes/init.php";
require "filters/auth.filter.php";

if(!empty($_GET['id']) && $_GET['id'] === get_session('pseudo')) {

    // Informations sur User
    $user = find_user_by_id(get_session('user_id'));

    //  Nombre de tables de User
    $nboard = find_nbr_x_in_table(get_session('user_id'), 'u_id', 'boards');

    //  Toutes les tables de User
    $boards = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'boards', 'ORDER BY id DESC');

    //  Toutes les tables populaires de User
    $populaires = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'boards', 'LIMIT 5');

    //  Transcription de la date d'inscription en Français
    $user->created_at = date_to_fr(strftime("%b %Y", strtotime($user->created_at)));

    if(!$user) {

        set_flash("Impossible de trouver cet utilisateur!", 'danger');

        redirect('profile.php?id='.$user->id);

    }

    //  Définision du changement de tabs
    if(isset($_GET['tab']) && $_GET['tab'] === "boards") {

        $checked = 'checked="checked"';

    } else {

        $checked = '';

    }



} else {

    redirect('profile.php?id='.get_session('pseudo'));

}


//  dashboard.view.php -> Insertion de la vue de la page dashboard.
require('views/profile.view.php');