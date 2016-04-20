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

    if(isset($_POST['newboard_btn'])) {

        if(not_empty(['boardname'])) {

            $errors = [];

            extract($_POST);

            $boardname = trim($boardname);
            $trimed_boardname = str_replace(' ', '.', $boardname);

            if(mb_strlen($boardname) < 4) {

                $errors[] = "Le nom du tableau est trop court. Minimum quatre (4) caractères sont réquis!";

            }

            if(is_field_already_in_use_by_user($boardname, 'boards', get_session('user_id'), 'u_id', 'title')) {

                $errors[] = "Vous avez déjà un tableau qui porte le même nom!";

            }

            if(mb_strlen($boarddesc) > 140) {

                $errors[] = "Votre description est bien trop longue!";

            }

            if(count($errors) == 0) {

                $story_title = "Utilisateur.Tableau";

                $story_msg = "Vous avez créer avec sucès un nouveau tableau: ".$boardname.".";

                // CREATION
                $q = $db->prepare("INSERT INTO boards(u_id, title, link, description, created_at, status, last_modif_date)
                              VALUES(:u_id, :title, :link, :description, :created_at, :status, :last_modif_date)");

                set_story_msg($story_title, $story_msg, 'security_story', get_session('user_id'), '');

                $q->execute([
                    'u_id' => get_session('user_id'),
                    'title' => $boardname,
                    'link' => $trimed_boardname,
                    'description' => $boarddesc,
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => $boardacces,
                    'last_modif_date' => date('Y-m-d H:i:s'),
                ]);

                $last_id = $db->lastInsertId();

                $board = find_table_by_id($last_id);

                set_flash("Félicitations, votre tableau a bien été créer!", "succes");

                redirect('board.php?b='. $board->link);

            } else {

                save_input_data();

            }

        } else {

            save_input_data();

            $errors[] = "Veuillez remplir tous les champs marqués par d'un (*)";

        }

    } else {

        clear_input_data();

    }


} else {

    redirect('profile.php?id='.get_session('user_id'));

}


//  new.board.view.php -> Insertion de la vue de la page de création de tableau.
require('views/new.board.view.php');
