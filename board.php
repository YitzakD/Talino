<?php
/**
 * User: Yitzak DEKPEMOU
*/
session_start();
require "includes/init.php";
require "filters/auth.filter.php";

if(get_session('pseudo') && get_session('user_id')) {

    $board = find_one_id_in_table($_GET['b'], "link", "boards", "and u_id = ", get_session('user_id'));

    if(!empty($_GET['b']) && $_GET['b'] === $board->link) {

        $boardscounter = cell_count('boards', 'u_id', get_session('user_id'));

        $uboards = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'boards', 'and archivate="0"', 'order by id asc');

        $notecounter = cell_count('notes', 'u_id', get_session('user_id'));

    } else {

        set_flash("Vous n'avez pas les accès nécéssaires pour acceder à cet tableau!","danger");

        redirect('profile.php?id='.get_session('pseudo').'&tab=boards');

    }

} else {

    redirect('profile.php?id='.get_session('pseudo'));

}

require "views/board.view.php";
