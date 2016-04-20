<?php
/**
 * User: Yitzak DEKPEMOU
*/

// Database credentials
define("DB_HOST", "localhost");
define("DB_NAME", "_DatabaseName_");
define("DB_USERNAME", "_DatabaseUser_");
define("DB_PASSWORD", "_DataBasePassword_");
setlocale(LC_ALL, 'fr_FR');

try{
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    die("Erreur : " .$e->getMessage());
}
