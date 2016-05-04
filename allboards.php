<?php
/**
 * User: Yitzak DEKPEMOU
 */
session_start();
require "includes/init.php";
require "filters/auth.filter.php";

if(isset($_GET['id']) && ($_GET['id'] === get_session('pseudo')) && get_session('user_id')) {

    if(!empty($_GET['tab']) && ($_GET['tab'] === "closed" || $_GET['tab'] === "stared")) {

        $stared = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'boards', 'and contributions > "1" and archivate = "0"', 'order by contributions desc');

        $closed = find_in_table_by_external_key(get_session('user_id'), 'u_id', 'boards', 'and archivate = "1"', 'order by contributions desc');

        $nstared =  cell_count('boards', 'u_id', get_session('user_id'), 'and contributions > "1" and archivate = "0"');

        $nclosed =  cell_count('boards', 'u_id', get_session('user_id'), 'and archivate = "1"');


        if(isset($_POST['re_open_board_btn'])) {

            $errors = [];

            if(not_empty(['closedBoardHiddenID'])) {

                extract($_POST);

                $board = find_table_by_id($closedBoardHiddenID);

                $story_msg = "a ré-ouvert ce tableau: <u>".$board->title."</u>";

                $j = $db->prepare("UPDATE notes SET archivate=:archivate WHERE u_id=:u_id AND b_id=:b_id");
                $k = $db->prepare("UPDATE board_list SET archivate=:archivate WHERE u_id=:u_id AND b_id=:b_id");
                $q = $db->prepare("UPDATE boards SET archivate=:archivate WHERE u_id=:u_id AND id=:id");

                set_story_msg('', $story_msg, 'activities_story', get_session('user_id'), $closedBoardHiddenID);

                $j->execute([
                    'archivate' => '0',
                    'u_id' => get_session('user_id'),
                    'b_id' => $closedBoardHiddenID
                ]);
                $k->execute([
                    'archivate' => '0',
                    'u_id' => get_session('user_id'),
                    'b_id' => $closedBoardHiddenID
                ]);
                $q->execute([
                    'archivate' => '0',
                    'u_id' => get_session('user_id'),
                    'id' => $closedBoardHiddenID
                ]);

                $j->closeCursor();
                $k->closeCursor();
                $q->closeCursor();

                set_flash("Félicitations, vous avez ré-ouvert ce tableau: '".$board->title."' avec succès.", "succes");

                redirect('board.php?b='.$board->link);

            } else {
                save_input_data();

                $errors[] = "Veuillez remplir tous les champs marqués par d'un (*)";
            }

        } else {

            clear_input_data();

        }


    } else {
        redirect('allboards.php?id='.get_session('pseudo').'&tab=stared');
    }

} else {

    redirect('allboards.php?id='.get_session('pseudo').'&tab=stared');

}

require "views/allboards.view.php";