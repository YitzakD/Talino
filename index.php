<?php
/**
 * User: Yitzak DEKPEMOU
*/

//  SESSION START
session_start();
//  Insertion des needed.
require "includes/init.php";
require "filters/auth.filter.php";

if(get_session('user_id')) {

    redirect_by_intention('dashboard.php?id='.get_session('user_id'));

} else {

    redirect('home.php');

}

