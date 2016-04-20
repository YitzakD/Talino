<?php
/**
 * User: Yitzak DEKPEMOU
 */

//  SESSION START
session_start();
//  Insertion des needed.
require "includes/init.php";
require "filters/guest.filter.php";

/**
 * Codeur: Yitzak DEKPEMOU
 * Code de gestion de la page index (Register / Login)
 */
//  REGISTER
if(isset($_POST['sign_up'])) {

    //  Si tous les champs ont été remplis
    if(not_empty(['pseudo', 'email', 'password'])) {

        $errors = [];    // Tableau contenant l'ensemble des erreurs

        extract($_POST); // Extraction des valeurs postés

        //  Verification du nombre de caractèques du pseudo
        $pseudo = trim($pseudo);
        $pseudo = str_replace(' ', '.', $pseudo);

        if(mb_strlen($pseudo) < 3) {

            $errors[] = "Pseudo trop court. Minimum trois (3) caractères sont réquis!";

        }

        //  Verification de l'authenticité de l'adresse E-mail
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $errors[] = "* L'adresse E-mail est invalide!";

        }

        //  Verification du nombre de caractèques du mot de passe
        if(mb_strlen($password) < 6) {

            $errors[] = "* Mot de passe trop court. Minimum six (6) caractères sont réquis!";

        }

        //  Vérification de l'unicité du pseudo
        if(is_already_in_use('pseudo', $pseudo, 'users')) {

            $errors[] = "Le pseudo est déjà utilisé!";

        }

        //  Vérification de l'unicité de l'adresse E-mail
        if(is_already_in_use('email', $email, 'users')) {

            $errors[] = "* L'adresse E-mail est déjà utilisé!";

        }

        //  Verification de l'existence d'érreurs
        if(count($errors) == 0) {
            //  Envoi d'un mail d'activation
            $to = $email;
            $subject = WEBSITE_NAME . " - ACTIVATION DE COMPTE";

            $password = bcrypt_hash_password($password);
            $token = sha1($pseudo.$email.$password);

            ob_start();
            require('templates/emails/activation.tmpl.php');
            $content = ob_get_clean();

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: '.WEBSITE_NAME.' <'.ACTIVATION_EMAIL.'>' . "\r\n" .
                'Reply-To: '.WEBSITE_NAME.' <'.ACTIVATION_EMAIL.'>' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $content, $headers);

            //  Informe l'utilisateur pour qu'il vérifie sa boite de réception mail
            set_flash("Un mail d'activation a été envoyé à l'adresse: <a href='#' class='btn-link blanco'>" . $email . "</a>.", "succes");

            //  Sauvegarde des données postées
            $q = $db->prepare("INSERT INTO users(pseudo, email, password, created_at) VALUES(:pseudo, :email, :password, :created_at)");

            $q->execute([
                'pseudo' => $pseudo,
                'email' => $email,
                'password' => $password,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $u_id = $db->lastInsertId();

            if($u_id) {

                $j = $db->prepare("INSERT INTO users_avatar(u_id, avatar) VALUES(:u_id, :avatar)");
                $k = $db->prepare("INSERT INTO users_mails(u_id, email, status, re_order, notifications)
                                    VALUES(:u_id, :email, :status, :re_order, :notifications)");

                $k->execute([
                    'u_id' => $u_id,
                    'email' => $email,
                    'status' => "Private",
                    're_order' => "1",
                    'notifications' => "1"
                ]);
                $j->execute([
                    'u_id' => $u_id,
                    'avatar' => ""
                ]);

            }

            //  redirection vers une certaine page
            redirect('index.php#ancre_login');

        } else {

            save_input_data();

        }

    } else {

        $errors[] = "Veuillez remplir tous les champs!";

        save_input_data();

    }

} else {

    clear_input_data();

}

//  LOGIN
if(isset($_POST['login_in'])) {

    // Si tous les champs ont été remplis
    if(not_empty(['identifiant', 'password'])) {

        extract($_POST); // Extraction des valeurs postés

        $q = $db->prepare("SELECT users.id, users.pseudo, users.email, users.password AS hashed_password
                            FROM users
                            LEFT JOIN users_infos
                            ON users_infos.u_id = users.id
                            WHERE (users.pseudo = :identifiant OR users.email = :identifiant)
                            AND users.active = '1' ");

        $q->execute([
            'identifiant' => $identifiant
        ]);

        $user = $q->fetch(PDO::FETCH_OBJ);



        if($user && bcrypt_verify_password($password, $user->hashed_password)) {

            $_SESSION['user_id'] = $user->id;

            $_SESSION['pseudo'] = $user->pseudo;

            $_SESSION['email'] = $user->email;

            // Quand l'utilisateur choisit de garder sa page active.
            if(isset($_POST['rememberme']) && $_POST['rememberme'] == 'on') {

                remember_me($user->id);

            }

            redirect("dashboard.php?id=".$user->pseudo);

        } else {

            set_flash("La combinaison Identifiant / Mot de passe est incorrecte!", "danger");

            save_input_data();
        }

    }

} else {

    clear_input_data();

}

//  home.view.php -> Insertion de la vue de la page index.
require('views/home.view.php');
