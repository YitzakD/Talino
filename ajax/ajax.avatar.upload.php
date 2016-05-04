<?php
session_start();
require "../config/database.php";
require "../includes/functions.php";
require "../includes/constants.php";
require "../filters/auth.filter.php";
require "../includes/classes/images.class.php";

$xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

if (!$xhr){

    echo '<div class="set-uploads-infos text-size-1x text-danger">Impossible d\'effectuer cette opération.';

}

?>

<?php
$userPseudo = get_session('pseudo');
$userId = get_session('user_id');

$upload_path = '../assets/uploads/avatars/'.$userPseudo.'/';
$upload_min_path = $upload_path.'min/';

// Verifie si l'utilisateur à son dossier image
if(!file_exists($upload_path)) {
    mkdir($upload_path, 0700);
}
if(!file_exists($upload_min_path)) {
    mkdir($upload_min_path, 0700);
}

$max_filesize = 7340032; // Maximum filesize in BYTES.

$allowed_filetypes = array('.jpg','.JPG','.jpeg','.JPEG','.gif','.GIF','.png','.PNG'); //   Définie les extentions souhaitées

$filename = $_FILES['set_img']['name']; //  Déclare la variable

$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); //    Check les extenstions dans le fichiers en paramètres

$_FILES['set_img']['name'] = $userPseudo.rand(0, 999).'.jpg'; //  Redefinie le nom du fichier

$finalname = $_FILES['set_img']['name'];

//  Vérifie si l'extention est ok
if(!in_array($ext,$allowed_filetypes)) {

    echo '<div class="set-uploads-infos blocked text-size-1x text-danger">
            L\'estension de ce fichier n\'est pas autorisée.
            </div>';

    die('<div class="set-uploads-infos blocked text-size-1x">
            <i class="fa fa-info td-color-grey"></i>&nbsp;<span class="td-color-ld">Les extensions autorisées sont: Jpeg, Jpg, Png, Gif.</span>
            </div>');

}

// On verifie la taille du fichier.
if(filesize($_FILES['set_img']['tmp_name']) > $max_filesize) {

    echo '<div class="set-uploads-infos blocked text-size-1x text-danger">
            Le fichier que vous tenter de charger est bien trop lourd.
            </div>';

    die('<div class="set-uploads-infos blocked text-size-1x">
            <i class="fa fa-info td-color-grey"></i>&nbsp;<span class="td-color-ld">Taille maximum de fichier acceptée: 7Mo</span>
            </div>');

}

// On vérifie si l'utilisateur à le droit d'écriture.
if(!is_writable($upload_path)) {

    echo '<div class="set-uploads-infos blocked text-size-1x text-danger">
            Vous n\'avez pas les droits nécessaires pour souùettre cette opération.
            </div>';

    die('<div class="set-uploads-infos blocked text-size-1x">
            <i class="fa fa-info td-color-grey"></i>&nbsp;<span class="td-color-ld">Verifier vos droits d\'accès.</span>
            </div>');

}

// Ondéplace le fichier du tmp ver le dossier de destination finale.
if(!move_uploaded_file($_FILES['set_img']['tmp_name'],$upload_path . $finalname)) {
    echo '<div class="set-uploads-infos blocked text-size-1x text-danger">
            Le fichier n\'a pas pu être charger.
            </div>';

    die('<div class="set-uploads-infos blocked text-size-1x">
            <i class="fa fa-info td-color-grey"></i>&nbsp;<span class="td-color-ld">Vérifier l\'extension ou la taille du fichier.</span>
            </div>');
} else {
    $q = $db->prepare("UPDATE users_avatar SET avatar = ? WHERE u_id = ?");
    $q->execute([$upload_min_path.$finalname, $userId]);

    Img::creerMin($upload_path.$finalname,$upload_min_path,$finalname,500,500);
    echo "<div class='set-uploads-infos blocked text-size-1x'>
            <span class=' td-color-ld'><i class='fa fa-check'></i>&nbsp;Votre image a été chargee avec suucès, cliquer sur le bouton Sauvegarder pour finir.</span>
            </div>";
}
?>

<?php

if(!$xhr){
    echo '</div>';
}

?>
