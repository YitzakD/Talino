/**
 * Created by Yitzak DEKPEMOU on 16/03/2016.
 */
$(document).ready(function(){

    /* all scrollers -> qui affiche les scrollers adaptés */
    $("body").niceScroll({styler:"fb", cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"300", cursorborderradius:"3px"});

    // Pour la fermeture de pop-ups des alertes
    $(".dot-close").click(function() {

        $(this).parent().fadeOut(700);

        return false;

    });

});
