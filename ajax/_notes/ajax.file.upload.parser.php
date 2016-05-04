<?php
header('content-type: application/json');

session_start();
require "../../config/database.php";
require "../../includes/functions.php";
require "../../includes/constants.php";
require "../../filters/auth.filter.php";

$userPseudo = get_session('pseudo');
$userFolder = 'assets/uploads/notes/'.$userPseudo.'/';
if(!file_exists('../../'.$userFolder)) {
    mkdir('../../'.$userFolder, 0700);
}

$h = getallheaders();

$o = new stdClass();
$source = file_get_contents('php://input');
$type = Array('image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/PNG', 'image/GIF', 'image/JPEG', 'image/JPG');

if(!in_array($h['x-file-type'], $type)) {
    $o->error = "Le format n'est pas pris en compte.";
} else {
    if(isset($h['x-param-value'])) {
        unlink('../../'.$userFolder.$h['x-param-value']);
    }
    file_put_contents('../../'.$userFolder.$h['x-file-name'], $source);

    $o->name = $h['x-file-name'];
    $o->content = '<img class="min-raduised" src="'.$userFolder.$h['x-file-name'].'" />';

}

echo json_encode($o);