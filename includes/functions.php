<?php
/**
 * User: Yitzak DEKPEMOU
 */

//  e function -> permet d'échaper les valeurs entrées par les users
if(!function_exists('e')) {

    function e($string) {

        if($string) {

            return htmlspecialchars(strip_tags($string));

        }

    }

}

//  date_to_fr function retourn le formet de la date en fr
if(!function_exists('date_to_fr')) {

    function date_to_fr($date) {

        //  Passage des jours de la semaine de l'anglais au français
        $date = str_replace ("Monday", "Lundi", $date);
        $date = str_replace ("Tuesday", "Mardi", $date);
        $date = str_replace ("Wednesday", "Mercredi", $date);
        $date = str_replace ("Thursday", "Jeudi", $date);
        $date = str_replace ("Friday", "Vendredi", $date);
        $date = str_replace ("Saturday", "Samedi", $date);
        $date = str_replace ("Sunday", "Dimache", $date);

        //  Passage des mois de l'année de l'anglais au français
        $date = str_replace ("January", "Janvier", $date);
        $date = str_replace ("February", "Février", $date);
        $date = str_replace ("March", "Mars", $date);
        $date = str_replace ("April", "Avril", $date);
        $date = str_replace ("May", "Mai", $date);
        $date = str_replace ("June", "Juin", $date);
        $date = str_replace ("July", "Juillet", $date);
        $date = str_replace ("August", "Août", $date);
        $date = str_replace ("September", "Septembre", $date);
        $date = str_replace ("October", "Octobre", $date);
        $date = str_replace ("November","Novembre" , $date);
        $date = str_replace ("December", "Décembre", $date);

        //  Passage des mois de l'année de l'anglais au français
        $date = str_replace ("Jan", "Janv", $date);
        $date = str_replace ("Feb", "Fév", $date);
        $date = str_replace ("Mar", "Mars", $date);
        $date = str_replace ("Apr", "Avril", $date);
        $date = str_replace ("May", "Mai", $date);
        $date = str_replace ("June", "Juin", $date);
        $date = str_replace ("July", "Juil", $date);
        $date = str_replace ("Aug", "Août", $date);
        $date = str_replace ("Sept", "Sept", $date);
        $date = str_replace ("Oct", "Oct", $date);
        $date = str_replace ("Nov","Nov" , $date);
        $date = str_replace ("Dec", "Déc", $date);

        return ($date);
    }

}

//  get_session function -> Gère les clé sauvées en session.
if(!function_exists('get_session')) {

    function get_session($key) {

        if($key) {

            return !empty($_SESSION[$key])
                ? e($_SESSION[$key])
                : null;

        }

    }

}

//  is_logged_in function -> Vérifie si un user est connecté, et qu'une session à bien été créer.
if(!function_exists('is_logged_in')) {

    function is_logged_in() {

        return isset($_SESSION['user_id']) || isset($_SESSION['pseudo']);

    }

}

//  bcrypt_hash_password function -> Hashage du mot de passe avec l'algorithme bcrypt.
if(!function_exists('bcrypt_hash_password')) {

    function bcrypt_hash_password($value, $options = array()) {

        //  coast
        $cost = isset($options['rounds']) ? $options['rounds'] : 10;

        $hash = password_hash($value, PASSWORD_BCRYPT, array('cost' => $cost));

        if($hash === false) {
            throw new Exception("Bcrypt hashing n'est pas supporté.");
        }

        return $hash;

    }

}

//  bcrypt_verify_password function -> Vérification du mot de passe hashé avec l'algorithme bcrypt.
if(!function_exists('bcrypt_verify_password')) {

    function bcrypt_verify_password($value, $hashedValue) {

        return password_verify($value, $hashedValue);

    }

}

//  remember_me function -> Permet l'enregistrement des différents tokens et selectors de sécurité quand
//  un user veut que le navigateur se souvienne de lui sur le site.
if(!function_exists('remember_me')) {

    function remember_me($user_id) {

        //  Code
        global $db;

        //  Genère le #token de manière aléatoire
        $token = openssl_random_pseudo_bytes(24);

        //  Genère le #selector(selecteur) de manière aléatoire et s'assurer que celui ci est unique
        do{
            $selector = openssl_random_pseudo_bytes(9);
        } while(cell_count('auth_tokens', 'selector', $selector) > 0);

        //  Sauvegarder les infos (user_id, selector, expires(14jrs), token(hashed)) dans la bdd
        $q = $db->prepare("INSERT INTO auth_tokens(expires, selector, user_id, token)
                           VALUES(DATE_ADD(NOW(), INTERVAL 14 DAY), :selector, :user_id, :token)");

        $q->execute([
            'selector' => $selector,
            'user_id' => $user_id,
            'token' => hash('sha256', $token)
        ]);

        //  Créer un cookie 'auth' (14jrs expires) httpOnly => true
        //  Contenu => base64_encode(selector).':'.base64_encode(token)
        setcookie(
            'auth',
            base64_encode($selector).':'.base64_encode($token),
            time()+1209600,
            null,
            null,
            false,
            true
        );

    }

}

//  auto_login function -> verifie le cookie afin de permettre la connection automatique du user
//  quand celui ci coche le champ 'remember me'.
if(!function_exists('auto_login')) {

    function auto_login() {

        //  Code
        global $db;

        //  Verifier que le cookie 'auth' existe
        if(!empty($_COOKIE['auth'])) {
            $split = explode(':', $_COOKIE['auth']);

            if(count($split) !==  2) {
                return false;
            }

            //  Récuperer via le cookie le 'selector', et le 'token'
            $selector = $split[0];
            $token = $split[1];
            //  equivalent de la structure ci-dessus <-[ list($selector, $token) = $split; ]->

            $q = $db->prepare("SELECT auth_tokens.token, auth_tokens.user_id,
                               users.pseudo, users.email, users.id
                               FROM auth_tokens
                               LEFT JOIN users
                               ON auth_tokens.user_id = users.id
                               WHERE auth_tokens.selector = ? AND auth_tokens.expires >= CURDATE()");

            $q->execute([base64_decode($selector)]);

            $data = $q->fetch(PDO::FETCH_OBJ);

            //  Si enregistrement trouvé, comparer  les $token
            if($data) {
                if(hash_equals($data->token, hash('sha256',base64_decode($token)))) {
                    session_regenerate_id(true);

                    $_SESSION['user_id'] = $data->id;
                    $_SESSION['pseudo'] = $data->pseudo;
                    $_SESSION['email'] = $data->email;

                    return true;
                }
            }

        }

        return false;

    }

}

// redirect function -> Redirige les users
if(!function_exists('redirect')) {

    function redirect($page) {

        header('Location: ' . $page);

        exit();
    }

}

//  redirect_by_intention function -> permet de rédiriger les users en fonction de leurs intentions.
if(!function_exists('redirect_by_intention')) {

    function redirect_by_intention($defaut_url) {

        if($_SESSION['fowarding_url']) {

            $url = $_SESSION['fowarding_url'];

        } else {

            $url = $defaut_url;

        }

        $_SESSION['fowarding_url'] = null;

        redirect($url);

    }

}

//  find_user_by_id function -> Recupère les infos des users en fonction de l'id.
if(!function_exists('find_user_by_id')) {

    function find_user_by_id($id) {

        global $db;

        $q = $db->prepare("SELECT
                          users.pseudo,
                          users.created_at,
                          users_mails.email,
                          users_mails.status,
                          users_infos.*,
                          users_avatar.*
                          FROM users
                          LEFT JOIN
                          users_infos ON users_infos.u_id = users.id
                          LEFT JOIN
                          users_mails ON users_mails.u_id = users.id
                          LEFT JOIN
                          users_avatar ON users_avatar.u_id = users.id
                          WHERE users.id = ?");

        $q->execute([$id]);

        $data = $q->fetch(PDO::FETCH_OBJ);

        $q->closeCursor();

        return $data;

    }

}

//  get_avatar function -> Recupère l'avatar de l'user
if(!function_exists('get_avatar')) {

    function get_avatar() {

        return "assets/media/default.png";

        /* return "http://gravatar.com/avatar/".md5(strtolower(trim(e($email)))); */

    }

    function set_avatar($id) {

        $data = find_user_by_id($id);

        if($data->avatar != '' || $data->avatar != 'default.png'){

            $parts = explode('../', $data->avatar);
            $avatar = $parts[1];

            return $avatar;
        }

    }

}

// find_table_by_id function -> recupère les infos d'un tableau en fonction de l'id.
if(!function_exists('find_table_by_id')) {

    function find_table_by_id($id) {

        global $db;

        $q = $db->prepare("SELECT * FROM boards WHERE id = ?");

        $q->execute([$id]);

        $data = $q->fetch(PDO::FETCH_OBJ);

        $q->closeCursor();

        return $data;

    }

}

//  cell_count function -> retourne le nombre d'enregistrements trouvés.
if(!function_exists('cell_count')) {

    function cell_count($table, $field_name, $field_value, $additional = "") {

        global $db;

        $q = $db->prepare("SELECT * FROM $table WHERE $field_name = ? $additional");

        $q->execute([$field_value]);

        return $q->rowCount();

    }

}

//  find_nbr_list_in_table function -> Retourne le nombre d'enregistrement trouvés en fonction d'un id bien précis.
if(!function_exists('find_nbr_x_in_table')) {

    function find_nbr_x_in_table($id, $field_name, $table) {

        global $db;

        $q = $db->prepare("SELECT id FROM $table WHERE $field_name = ?");

        $q->execute([$id]);

        $data = $q->rowCount();

        $q->closeCursor();

        return $data;

    }

}

//  find_in_table_by_external_key function -> Retourn tous les enregistrements d'une table en fonction d'une clé étrangère.
if(!function_exists('find_in_table_by_external_key')) {

    function find_in_table_by_external_key($ext_key, $field_name, $table, $additional = "", $additional_value = "") {

        global $db;

        $q = $db->prepare("SELECT
                          *
                          FROM $table
                          WHERE $field_name = ? $additional $additional_value");

        $q->execute([$ext_key]);

        $data = $q->fetchAll(PDO::FETCH_OBJ);

        $q->closeCursor();

        return $data;

    }

}

//  find_in_table_by_external_key_by_order function -> Retourn tous les enregistrements d'une table en fonction d'une clé
//  dans un ordre donné.
if(!function_exists('find_in_table_by_external_key_by_order')) {

    function find_in_table_by_external_key_by_order($key, $field_name, $table, $order, $additional = "", $additional_value = "") {

        global $db;

        $q = $db->prepare("SELECT
                          *
                          FROM $table
                          WHERE $field_name = ?
                          ORDER BY id $order $additional $additional_value");

        $q->execute([$key]);

        $data = $q->fetchAll(PDO::FETCH_OBJ);

        $q->closeCursor();

        return $data;

    }

}

//  find_one_id_in_table function -> retourne tous les enregistrements avec l'id passé en paramètres.
if(!function_exists('find_one_id_in_table')) {

    function find_one_id_in_table($id, $field, $table, $additional = "", $additional_value = "") {

        global $db;

        $q = $db->prepare("SELECT
                          *
                          FROM $table
                          WHERE $field = ? $additional $additional_value");

        $q->execute([$id]);

        $data = $q->fetch(PDO::FETCH_OBJ);

        $q->closeCursor();

        return $data;

    }

}

//  delete_id_in_table function -> Efface l'enregistrement dont l'id est passé en paramètre.
if(!function_exists('delete_x_by_table')) {

    function delete_x_by_table($id, $field, $table) {

        global $db;

        $q = $db->prepare("DELETE FROM $table WHERE $field = ? ");

        $q->execute([$id]);

        $q->closeCursor();

        //  return $data;
    }

}

//  not_empty function -> verifie si une variable est vide.
if(!function_exists('not_empty')) {

    function not_empty($fields = []) {

        if(count($fields) != 0) {

            foreach($fields as $field) {

                if(empty($_POST[$field]) || trim($_POST[$field]) == "") {

                    return false;

                }

            }

            return true;

        }

    }

}

//  is_already_in_use function -> verifie l'unicité d'une variable
if(!function_exists('is_already_in_use')) {

    function is_already_in_use($field, $value, $table) {

        global $db;

        $q = $db->prepare("SELECT id FROM $table WHERE $field = ?");

        $q->execute([$value]);

        $count = $q->rowCount();

        $q->closeCursor();

        return $count;

    }

}

//  is_field_already_in_use_by_user function -> Vérifie l'unicité d'une variable par rapport à l'id de du user connecté.
if(!function_exists('is_field_already_in_use_by_user')) {

    function is_field_already_in_use_by_user($value, $table, $session, $external_key, $field_name) {

        global $db;

        $q = $db->prepare("SELECT id FROM $table WHERE $external_key = $session AND $field_name = ?");

        $q->execute([$value]);

        $count = $q->rowCount();

        $q->closeCursor();

        return $count;

    }

}

// set_flash function -> Gère les notificationds
if(!function_exists('set_flash')) {

    function set_flash($message, $type = 'info') {

        $_SESSION['notification']['message'] = $message;

        $_SESSION['notification']['type'] = $type;

    }

}

//  save_input_data function -> permet de sauver dans une SESSION les infos saisies par les utilisateurs en cas d'erreurs
if(!function_exists('save_input_data')) {

    function save_input_data() {

        foreach($_POST as $key => $value) {

            if(strpos($key, 'password') === false) {

                $_SESSION['input'][$key] = $value;

            }

        }

    }

}

//  get_input function -> retourne la valeur de la clé sauver dans en SESSION en cas d'erreurs
if(!function_exists('get_input')) {

    function get_input($key) {

        if(!empty($_SESSION['input'][$key])) {

            return e($_SESSION['input'][$key]);

        } else {

            return null;

        }

    }

}

//  get_curr_locale function -> Récupère la langue qui est sauvé en session
if(!function_exists('get_curr_locale')) {

    function get_curr_locale() {

        return $_SESSION['local'];

    }

}

//  clear_input_data function -> permet d'effacer les variables sauver dans les SESSION
if(!function_exists('clear_input_data')) {

    function clear_input_data() {

        if(isset($_SESSION['input'])) {

            $_SESSION['input'] = [];

        }

    }

}

//  set_active function -> permet de changer l'etat des btns du menu.
if(!function_exists('set_active')) {

    function set_active($lien, $class='lien_menu') {

        $anchor = strrchr($_SERVER['SCRIPT_NAME'], '#');

        if($anchor == '#'.$lien) {

            return $class;

        } else {

            return "";

        }

    }

}

//  Read_more function -> Permet de moceler un text en affichant un liens lre la suite
if(!function_exists('read_more')) {
    function read_more($long_text, $limit = 50){

        $words = explode(" ",$long_text);

        $readmore = implode(" ",array_splice($words,0,$limit));
        if($limit >= 50) {
            $readmore .= "...";
        }

        return $readmore;

    }

}

//  get_table_icon function -> retourn l'icone en fonction du type de tableau
if(!function_exists('get_table_icon')) {

    function get_table_icon($priv) {

        if($priv == "Private") {

            echo "<i class='fa fa-lock'></i>&nbsp;";

        } else {

            echo "<i class='fa fa-bookmark-o'></i>&nbsp;";

        }

    }

}

//  set_security_story -> Enregistre un message dans l'historique de sécurité
if(!function_exists('set_story_msg')) {

    function set_story_msg($title, $msg, $table, $id, $other) {

        global $db;

        $q = $db->prepare("INSERT INTO $table(u_id, b_id,  title, description, created_at)
                           VALUES(:u_id, :b_id, :title, :description, :created_at)");

        $q->execute([
            'u_id' => $id,
            'b_id' => $other,
            'title' => $title,
            'description' => $msg,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $q->closeCursor();

    }

}

// set_contributions -> Permet de faire +1 à ala contribution du tableau
if(!function_exists('set_contributions')) {
    function set_contributions($id, $table, $counter, $session) {

        global $db;

        $q = $db->prepare("UPDATE $table
                           SET
                           contributions=:contributions,
                           last_modif_date=:last_modif_date
                           WHERE id=:id
                           AND u_id=:u_id");

        $q->execute([
            'contributions' => $counter,
            'last_modif_date' => date('Y-m-d H:i:s'),
            'id' => $id,
            'u_id' => $session
        ]);

         $q->closeCursor();

    }

}

//  set_time -> set time
if(!function_exists('set_time')) {

    function set_time($session_time){
        $time_difference = time() - $session_time ;
        $seconds = $time_difference ;
        $minutes = round($time_difference / 60 );
        $hours = round($time_difference / 3600 );
        $days = round($time_difference / 86400 );
        $weeks = round($time_difference / 604800 );
        $months = round($time_difference / 2419200 );
        $years = round($time_difference / 29030400 );

        if($seconds <= 60){
            echo"Il y a $seconds sec";
        }else if($minutes <=60){
            if($minutes==1){
                echo"Il y a 1 min";
            }else{
                echo"Il y a $minutes minutes";
            }
        }
        else if($hours <=24){
            if($hours==1){
                echo"Il y a 1 h";
            }else{
                echo"Il y a $hours heures";
            }
        }else if($days <=7){
            if($days==1){
                echo"Il y a 1 jr";
            }else{
                echo"Il y a $days jours";
            }
        }else if($weeks <=4){
            if($weeks==1){
                echo"Il y a 1 sem";
            }else{
                echo"il y a $weeks semaines";
            }
        }else if($months <=12){
            if($months==1){
                echo"Il y 1 mois";
            }else{
                echo"Il y a $months mois";
            }
        }else{
            if($years==1){
                echo"Il y a 1 an";
            }else{
                echo"Il y a $years ans";
            }
        }
    }

}
