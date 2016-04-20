/**
 * Created by Yitzak DEKPEMOU on 16/03/2016.
 */
$(document).ready(function(){
    // Gère le smooth scrolling au niveau des différents liens
    $(function() {

        $('a[href*="#"]:not([href="#"])').click(function() {

            if(location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {

                var target = $(this.hash);

                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

                if(target.length) {

                    $('html, body').animate({

                        scrollTop: target.offset().top

                    }, 700);

                    return false;

                }

            }

        });

    });

});