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

    /**
     *  Pages -> set active
    */
    //  Pages
    if (isset($_GET['page']) && $_GET['page'] != '') {

        $page = $_GET['page'];

    } else {

        $page = 'profile';

    }
    function set_settings_menu_active($url) {

        global $page;

        if ($page == $url) {

            echo 's-menu-link-active';

        }

    }

    /**
     *  Profile -> Ajout/Supression/Modification
    */
    //  Profile -> Informations sur User
    $user = find_user_by_id(get_session('user_id'));

    if(!$user) {

        set_flash("Vous n'êtes pas autoriser à faire cette manipulation!", 'danger');

        redirect('profile.php?id='.get_session('pseudo'));

    }

    //  Profile -> Ajout d'informations
    if(isset($_POST['set_up_ui_btn'])) {

        $errors = [];

        if(not_empty(['name', 'city', 'country', 'bio'])) {

            extract($_POST);

            if(is_already_in_use('u_id', get_session('user_id'), 'users_infos')) {

                // UPDATE
                $q = $db->prepare("UPDATE users_infos
                              SET
                              name = :name,
                              city = :city,
                              country = :country,
                              sex = :sex,
                              facebook = :facebook,
                              twitter = :twitter,
                              bio = :bio
                              WHERE u_id = :u_id
                             ");

                $q->execute([
                    'name' => $name,
                    'city' => $city,
                    'country' => $country,
                    'sex' => $sex,
                    'facebook' => $facebook,
                    'twitter' => $twitter,
                    'bio' => $bio,
                    'u_id' => get_session('user_id'),
                ]);

                $story_title = "Utilisateur.Profile";

                $story_msg = "Vous avez modifier vos informations de profile.";

                set_story_msg($story_title, $story_msg, 'security_story', get_session('user_id'), '');

                set_flash("Vos informations ont été bien mises à jour!", "info");

                redirect('settings.php?page=profile&id='.get_session('pseudo'));

            } else {

                // CREATION
                $q = $db->prepare("INSERT INTO users_infos(u_id, name, city, country, sex, facebook, twitter, bio)
                              VALUES(:u_id, :name, :city, :country, :sex, :facebook, :twitter, :bio)");

                $q->execute([
                    'u_id' => get_session('user_id'),
                    'name' => $name,
                    'city' => $city,
                    'country' => $country,
                    'sex' => $sex,
                    'facebook' => $facebook,
                    'twitter' => $twitter,
                    'bio' => $bio,
                ]);

                $story_title = "Utilisateur.Profile";

                $story_msg = "Vous avez modifier vos informations de profile.";

                set_story_msg($story_title, $story_msg, 'security_story', get_session('user_id'), '');

                set_flash("Félicitations, votre profle a bien été mis à jour!", "succes");

                redirect('settings.php?page=profile&id='.get_session('pseudo'));

            }

        } else {

            save_input_data();

            $errors[] = "Veuillez remplir tous les champs marqués par d'un (*)";

        }

    } else {

        clear_input_data();

    }
    /**
     *   Fin Profile
     */



    /**
     *  Admin -> Ajout/Supression/Modification
    */
    //  Admin -> Changement de mot de passe
    if(isset($_POST['change_psw_btn'])) {

        $errors = [];

        if(not_empty(['current_pass', 'new_pass', 'confirmed_pass'])) {

            extract($_POST);

            if(mb_strlen($new_pass) < 6) {

                $errors[] = "Mot de passe trop court. Minimum six (6) caractères sont réquis!";

            } else{

                if($new_pass != $confirmed_pass) {

                    $errors[] = "Les deux entrées ne sont pas identiques!";

                }

            }

            $story_title = "Utilisateur.Password";

            $story_msg = "Vous avez modifier avec sucès votre mot de passe.";

            if(count($errors) == 0) {

                $q = $db->prepare("SELECT password AS hashed_password FROM users WHERE (id = :id) AND active = '1' ");

                $q->execute([
                    'id' => get_session('user_id')
                ]);

                $user = $q->fetch(PDO::FETCH_OBJ);

                if($user && password_verify($current_pass, $user->hashed_password)) {

                    $q = $db->prepare("UPDATE users SET password = :password WHERE id = :id");

                    $q->execute([
                        'password' => password_hash($new_pass, PASSWORD_BCRYPT),
                        'id' => get_session('user_id')
                    ]);

                    set_story_msg($story_title, $story_msg, 'security_story', get_session('user_id'), '');

                    set_flash("Féllicitation votre mot de passe a été bien mis à jour!", "succes");

                    redirect('settings.php?page=admin&id='.get_session('pseudo'));

                } else {

                    save_input_data();

                    $errors[] = "Le mot de passe actuel indiqué ne concorde pas.";

                }

            }

        } else {

            save_input_data();

            $errors[] = "Veuillez remplir tous les champs marqués par d'un (*)";

        }


    } else {

        clear_input_data();

    }
    /**
     *   Fin Admin
     */



    /**
     *  Email -> Ajout/Supression/Modification
    */
    //  Email -> Informations email
    $usermailcount = cell_count('users_mails', 'u_id', get_session('user_id'));
    if($usermailcount) {

        //
        $usermails = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'users_mails', 'order by re_order', 'asc');

        //
        $r = $db->prepare("SELECT * FROM users_mails WHERE u_id=:u_id AND re_order=:re_order");
        $r->execute([
            'u_id' => get_session('user_id'),
            're_order' => '1'
        ]);
        $u_mail = $r->fetch(PDO::FETCH_OBJ);
        $r->closeCursor();

        //
        $s = $db->prepare("SELECT * FROM users_mails WHERE u_id=:u_id AND notifications=:notifications");
        $s->execute([
            'u_id' => get_session('user_id'),
            'notifications' => '1'
        ]);
        $mail_notif = $s->fetch(PDO::FETCH_OBJ);
        $s->closeCursor();
    }

    //  Email -> Ajout d'email
    if(isset($_POST['add_new_mail_btn'])) {

        $errors = [];

        if(not_empty(['new_mail'])) {

            extract($_POST);

            if(!filter_var($new_mail, FILTER_VALIDATE_EMAIL)) {

                $errors[] = "L'adresse E-mail est invalide!";

            }

            if(is_already_in_use('email', $new_mail, 'users_mails')) {

                $errors[] = "L'adresse E-mail est déjà utilisé!";

            }

            if(count($errors) == 0) {

                $q = $db->prepare("INSERT INTO users_mails(u_id, email, re_order) VALUES(:u_id, :email, :re_order)");

                $q->execute([
                    'u_id' => get_session('user_id'),
                    'email' => $new_mail,
                    're_order' => '2'
                ]);

                // Envoyer un mail de notification
                $to = $user->email;
                $subject = WEBSITE_NAME . " - NOTIFICATION";

                ob_start();
                require('templates/emails/newmail.tmpl.php');
                $content = ob_get_clean();

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: '.WEBSITE_NAME.' <'.ACTIVATION_EMAIL.'>' . "\r\n" .
                    'Reply-To: '.WEBSITE_NAME.' <'.ACTIVATION_EMAIL.'>' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $content, $headers);

                set_flash("Félicitations, votre adresse Email à été bien ajoutée!", "succes");

                redirect('settings.php?page=emails&id='.get_session('pseudo'));

            }

        } else {

            save_input_data();

            $errors[] = "Veuillez remplir tous les champs marqués par d'un (*)";

        }

    } else {

        clear_input_data();

    }

    //  Email -> Supression de mail
    if(isset($_POST['mail_to_delete'])) {

        extract($_POST);

        if(not_empty(['mail_id_to_delete'])) {

            $mtd = $mail_id_to_delete;

            $getEmail = find_one_id_in_table($mtd, 'id', 'users_mails');

            if($getEmail->u_id === get_session('user_id')) {

                delete_x_by_table($getEmail->id, 'id', 'users_mails');

                set_flash("L'adresse email à été supprimer avec succès!", 'succes');

                redirect('settings.php?page=emails&id='.get_session('pseudo'));

            } else {

                set_flash("Vous n'avez pas les droits nécessaires pour éffectuer cette opération.", 'danger');

                redirect("settings.php?page=emails&id=".get_session('pseudo'));

            }

        } else {

            set_flash("Impossible d'éffectuer cette opération.", 'danger');

            redirect("settings.php?page=emails&id=".get_session('pseudo'));

        }

    } else {

        clear_input_data();

    }

    //  Email -> Mettre en principal
    if(isset($_POST['mail_to_set'])) {

        extract($_POST);

        if(not_empty(['mail_id_to_set'])) {

            $mts = $mail_id_to_set;

            $getEmail = find_one_id_in_table($mts, 'id', 'users_mails');

            if($getEmail->u_id === get_session('user_id')) {

                $mcount = cell_count('users_mails', 'u_id', get_session('user_id'));

                if($mcount > 0) {

                    $j = $db->prepare("UPDATE users_mails SET re_order = :re_order WHERE u_id = :u_id");
                    $j->execute([
                        're_order' => '2',
                        'u_id' => get_session('user_id'),
                    ]);

                }

                $k = $db->prepare("UPDATE users_mails SET re_order = :re_order WHERE id = :id AND u_id = :u_id");
                $k->execute([
                    're_order' => '1',
                    'id' => $getEmail->id,
                    'u_id' => get_session('user_id')
                ]);

                $story_title = "Utilisateur.Email";

                $story_msg = "Vous avez modifier votre email principzle.";

                set_story_msg($story_title, $story_msg, 'security_story', get_session('user_id'), '');

                // Envoyer un mail de notification
                $to = $getEmail->email;
                $subject = WEBSITE_NAME . " - NOTIFICATION";

                ob_start();
                require('templates/emails/newmail.tmpl.php');
                $content = ob_get_clean();

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: '.WEBSITE_NAME.' <'.ACTIVATION_EMAIL.'>' . "\r\n" .
                    'Reply-To: '.WEBSITE_NAME.' <'.ACTIVATION_EMAIL.'>' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $content, $headers);

                $q = $db->prepare("UPDATE users SET email = :email WHERE id = :id");
                $q->execute([
                    'email' => $getEmail->email,
                    'id' => get_session('user_id')
                ]);

                set_flash("Vous avez changer votre adresse email principale pour ".$getEmail->email.". Un email de notification a été à cette adresse!", 'info');

                redirect('settings.php?page=emails&id='.get_session('pseudo'));

            } else {

                set_flash("Vous ne pouvez pas effectuer cette opération.", 'danger');

                redirect('settings.php?page=emails&id='.get_session('pseudo'));

            }

        } else {

            set_flash("Impossible d'éffectuer cette opération.", 'danger');

            redirect("settings.php?page=emails&id=".get_session('pseudo'));

        }


    } else {

        clear_input_data();

    }

    //  Email -> statut PRIVEE/PUBLIQUE
    if(isset($_POST['set_mail_status_btn'])) {

        $errors = [];

        if(not_empty(['u_status'])) {

            extract($_POST);

            $mcount = cell_count('users_mails', 'u_id', get_session('user_id'));

            if($mcount > 0) {

                $q = $db->prepare("UPDATE users_mails SET status = :status WHERE u_id = :u_id");
                $q->execute([
                    'status' => 'Private',
                    'u_id' => get_session('user_id'),
                ]);

            }

            $k = $db->prepare("UPDATE users_mails SET status = :status WHERE re_order = :re_order AND u_id = :u_id");
            $k->execute([
                'status' => $u_status,
                're_order' => '1',
                'u_id' => get_session('user_id')
            ]);


            if($u_status === "Private") {$new_status = "Privée";}else{$new_status = "Publique";}

            set_flash("Félicitations, votre adresse Email est maintenant "."' ".$new_status." '", "succes");

            redirect('settings.php?page=emails&id='.get_session('pseudo'));

        } else {

            save_input_data();

            $errors[] = "Veuillez remplir tous les champs marqués par d'un (*)";

        }

    } else {

        clear_input_data();

    }
    /**
     *   Fin Email
     */



    /**
     *  Notifications -> Ajout/Supression/Modification
    */
    //  Notifications -> Mise sous tension de l'etat de reception des notifications
    if(isset($_POST['set_notif_email_btn'])) {

        extract($_POST);

        if(not_empty(['email_to_notif'])) {

            $mcount = cell_count('users_mails', 'u_id', get_session('user_id'));

            if ($mcount > 0) {

                $k = $db->prepare("UPDATE users_mails SET notifications = :notifications WHERE u_id = :u_id");
                $k->execute([
                    'notifications' => '0',
                    'u_id' => get_session('user_id'),
                ]);

            }

            $q = $db->prepare("UPDATE users_mails SET notifications = :notifications WHERE id = :id AND u_id = :u_id");
            $q->execute([
                'notifications' => '1',
                'id' => $email_to_notif,
                'u_id' => get_session('user_id')
            ]);

            $story_title = "Utilisateur.Notifications";

            $story_msg = "Vous avez changer l'email de réception de notification.";

            set_story_msg($story_title, $story_msg, 'security_story', get_session('user_id'), '');

            set_flash('Vos mails de notifications seront désormais rédiriger vers cette adresse.','succes');

            redirect('settings.php?page=notifications&id='.get_session('pseudo'));

        } else {

            save_input_data();

            $errors[] = "Veuillez remplir tous les champs marqués par d'un (*)";
        }

    } else {

        clear_input_data();

    }
    /**
     *   Fin Notifications
     */



    /**
     *  Tableaux (Boards) -> Ajout/Supression/Modification
    */
    //  Tableaux -> Informations tableaux
    $boardscount = cell_count('boards', 'u_id', get_session('user_id')); // Nombre de tableaux
    $boards = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'boards', 'ORDER BY id DESC'); // Tableaux de l'utilisateurc connecté.
    //  Tableaux -> Supressions de tableaux
    if(isset($_POST['board_to_delete'])) {

        extract($_POST);

        if(not_empty(['board_id_to_delete'])) {

            $btd = $board_id_to_delete;

            $getBoard = find_one_id_in_table($btd, 'id', 'boards');

            if($getBoard->u_id === get_session('user_id')) {

                $story_title = "Utilisateur.Tableau";

                $story_msg = "Vous avez supprimé avec sucès un tableau: ".$getBoard->title.".";

                set_story_msg($story_title, $story_msg, 'security_story', get_session('user_id'), '');

                $notescounter = cell_count('notes', 'b_id', $getBoard->id);

                if($notescounter>0) {delete_x_by_table($getBoard->id, 'b_id', 'notes');}

                $listescounter = cell_count('board_list', 'b_id', $getBoard->id);

                if($listescounter>0) {delete_x_by_table($getBoard->id, 'b_id', 'board_list');}

                delete_x_by_table($getBoard->id, 'id', 'boards');

                set_flash("Vous avez supprimé un tableau!", 'succes');

                redirect('settings.php?page=admin.boards&id='.get_session('pseudo'));

            } else {

                set_flash("Vous n'avez pas les droits nécessaires pour éffectuer cette opération.", 'danger');

                redirect("settings.php?page=admin.boards&id=".get_session('pseudo'));

            }

        } else {

            set_flash("Impossible d'éffectuer cette opération.", 'danger');

            redirect("settings.php?page=admin.boards&id=".get_session('pseudo'));

        }

    } else {

        clear_input_data();

    }
    /**
     *   Fin Tableaux
    */



    /**
     *  Sécurité (Security) -> Informations
    */
    //  Security -> Ip/Nav/OS/Joined Date
    if($_GET['page'] === "security") {

        //  Security -> Navigateur
        if(strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') !== false){

            $navigateur = 'Mozilla Firefox';

        }elseif((strpos($_SERVER["HTTP_USER_AGENT"], 'Opera') OR strpos($_SERVER["HTTP_USER_AGENT"], 'OPR'))  !== false){

            $navigateur = 'Opera';

        }elseif(strpos($_SERVER["HTTP_USER_AGENT"], 'Netscape') !== false){

            $navigateur = 'Netscape';

        }elseif(strpos($_SERVER["HTTP_USER_AGENT"], 'Konqueror') !== false){

            $navigateur = 'Konqueror';

        }elseif(strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') !== false){

            $navigateur = 'Internet Explorer / Avant Browser';

        }elseif(strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') !== false){

            $navigateur = 'Chrome';

        }elseif(strpos($_SERVER["HTTP_USER_AGENT"], 'Maxthon') !== false){

            $navigateur = 'Maxthon';

        }else{

            $navigateur = '(navigateur inconnu)';

        }

        // Security -> OS
        function GetOS(){
            $tab = array('Win', 'Windows', 'Mac', 'Macintosh', 'Linux', 'FreeBSD', 'SunOS', 'IRIX', 'BeOS', 'OS/2', 'AIX');
            foreach($tab as $os){
                if(stripos($_SERVER['HTTP_USER_AGENT'], $os))
                    return $os;
            }
            return 'Autre';
        }
        $osys = GetOS();

        if($osys === "Win") {

            $osys = "Windows";

        } elseif($osys === "Mac") {

            $osys = "Macintosh";

        }



        //  Security -> Ip
        $ip = $_SERVER['REMOTE_ADDR'];
        $secu =  json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip='.$ip));

        /*
            geoplugin_request => 41.189.48.122,
            geoplugin_city => Abidjan,
            geoplugin_region => Lagunes,
            geoplugin_countryCode => CI,
            geoplugin_countryName => Cote D\Ivoire,
            geoplugin_regionName => Lagunes,
            geoplugin_currencyCode => XOF,
            geoplugin_currencySymbol => CFAF,
            geoplugin_currencySymbol_UTF8 => CFAF,
            geoplugin_currencyConverter => 576.0726,
        */

        //  Security -> Récupération des stories
        $hstories = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'security_story', 'order by id desc', 'limit 10');

    }
    /**
     *   Fin Sécurité
     */

} else {

    redirect('settings.php?page=profile&id='.get_session('pseudo'));

}


//  dashboard.view.php -> Insertion de la vue de la page dashboard.
require('views/settings.view.php');