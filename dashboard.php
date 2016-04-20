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

    //  Informations sur le User
    $user = find_user_by_id(get_session('user_id'));

    //  Limite
    $limit = 4;

    //  Nombre de tables de User
    $nboard = find_nbr_x_in_table(get_session('user_id'), 'u_id', 'boards');

    //  Toutes les tables de User
    $boards = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'boards', 'LIMIT', $limit);

} else {

    redirect('dashboard.php?id='.get_session('pseudo'));

}


//  dashboard.view.php -> Insertion de la vue de la page dashboard.
require('views/dashboard.view.php');
