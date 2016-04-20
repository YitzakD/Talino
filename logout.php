<?php
/**
 * User: Yitzak DEKPEMOU
*/

//  SESSION START

session_start();

//  Suppresion du token du remember me
require("config/database.php");
$q = $db->prepare("DELETE FROM auth_tokens WHERE user_id = ?");
$q->execute([$_SESSION['user_id']]);

//  Supression des cookies
setcookie('auth', '', time()-3600);

//  Supression de la session
session_destroy();
$_SESSION = [];

//  Redirection
header('Location:index.php');
