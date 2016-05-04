<?php
/**
 * User: Yitzak DEKPEMOU
 */

//  SESSION START
session_start();
//  Insertion des needed.
require('includes/init.php');
require('filters/guest.filter.php');

if(!empty($_GET['p']) &&
    is_already_in_use('pseudo', $_GET['p'], 'users') &&
    !empty($_GET['token'])
) {

    $pseudo = $_GET['p'];

    $token = $_GET['token'];

    $q = $db->prepare("SELECT email, password FROM users WHERE pseudo = :pseudo");

    $q->execute(['pseudo' => $pseudo]);

    $data = $q->fetch(PDO::FETCH_OBJ);

    $email = $data->email;

    $password = $data->password;

    $token_verif = sha1($pseudo.$email.$password);

    // die($token_verif);

    if($token == $token_verif) {

        $q = $db->prepare("UPDATE users SET active = '1' WHERE pseudo = :pseudo");

        $q->execute(['pseudo' => $pseudo]);

        set_flash('Votre compte à été activé avec succès. Vous pouvez à présent vous connecter!', 'succes');

        redirect('home.php#ancre_login');

    } else {

        set_flash('!Paramètres invalides...', 'danger');

        redirect('home.php');

    }


} else {

    redirect('home.php');

}