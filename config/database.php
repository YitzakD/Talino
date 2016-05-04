<?php
/**
 * User: Yitzak DEKPEMOU
*/

// Database credentials
define("DB_HOST", "localhost");
define("DB_NAME", "todo");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
setlocale(LC_ALL, 'fr_FR');

try{
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    die("Erreur : " .$e->getMessage());
}