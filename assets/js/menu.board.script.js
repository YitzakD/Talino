/**
 * Created by Yitzak DEKPEMOU on 14/04/2016.
 */
$(document).ready(function(){

    /* Menu -> ui affiche les options du menu */
    rightpusheropenbtn = $('span#js-open-menu');

    span = $('<span/>').attr('class', 'b-menu-acces nav-toggler toggle-push-right cur-to-point');
    span = span.attr('title', 'Fermer le menu');
    span = span.attr('id', 'js-close-menu');
    finalspan = span.html("<i class='fa fa-times'></i> Fermer");
    rightpusherclosebtn = finalspan;

    rightpusheropenbtn.click(function() {

        $(this).hide();
        rightpusherclosebtn.fadeIn();
        rightpusherclosebtn.appendTo($("div#js-board-menu"));

        rightpusher = $('.push-menu');
        pushed_board = $('#board');
        globalcontainer = $("#wrapper");
        color_menucontainer = $("#js-backcolor-menu-container");
        params_menucontainer = $("v#js-params-menu-container");
        acti_menucontainer = $("#js-activities-menu-container");

        rightpusher.css("right", "0px");
        pushed_board.css("right", "335px");
        loadprincipalmenu();

        rightpusher.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"90", cursorborderradius:"3px"});
        color_menucontainer.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"94", cursorborderradius:"3px"});
        color_menucontainer.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"94", cursorborderradius:"3px"});

        rightpusherclosebtn.click(function() {
            $(this).hide();
            color_menucontainer.css("right", "-500px");
            params_menucontainer.css("right", "-500px");
            acti_menucontainer.css("right", "-500px");

            rightpusher.css("right", "-335px");
            pushed_board.css("right", "0px");

            rightpusheropenbtn.fadeIn();
            loadprincipalmenu()

        });



    });

    function loadprincipalmenu() {

        prin_menucontainer = $("#js-principal-menu-container");

        bid = prin_menucontainer.attr("accesskey");

        $.post("ajax/ajax.board.menu.option.php", {bid:bid}, function(data) {
            prin_menucontainer.html(data);
            titlebox = prin_menucontainer.find("#js-menu-one");
            goback_colorbtn = prin_menucontainer.find("#js-mb-color-btn");
            goparam_btn = prin_menucontainer.find("#js-mb-params-btn");
            goactiv_btn = prin_menucontainer.find("#js-mb-activities-btn");

            titlebox.css("position", "fixed");

            /* Récupération de quelques activités */
            some_activities = $("#js-some-activities");
            $.post("ajax/_menu/ajax.some.activities.menu.php", {bid:bid}, function(someactivities) {

                if(someactivities !== "") {
                    some_activities.html(someactivities);
                    goactiv_innerbtn = some_activities.find("#js-mb-activities-btn");

                    goactiv_innerbtn.click(function() {
                        goactiv_btn.click();
                    })

                } else {
                    some_activities.html("Rien a charger pour le moment!");
                }
            });

            /* Menu de changement de couleur de fond */
            goback_colorbtn.click(function() {
                picker = color_menucontainer;
                picker.css("right", "0");
                picker.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"94", cursorborderradius:"3px"});

                loadbgcolor();

                function loadbgcolor() {
                    $.post("ajax/_menu/color.picker.menu.php", {bid:bid}, function(colorpicking) {
                        picker.html(colorpicking);
                        closer = picker.find("#js-close-opened");
                        bgccolor = $("div#js-bc-picker div#js-bc-picked");
                        titlebox = picker.find("#js-menu-one");

                        titlebox.css("position", "fixed").css("z-index", "10");

                        bgccolor.click(function() {
                            colorname = $(this).attr("title");
                            colorcode = $(this).attr("accesskey");

                            if(colorcode !== "") {
                                $.post('ajax/_menu/ajax.bgcolor.menu.php',{colorcode:colorcode, bid:bid},function(upbgcolor) {

                                    if(upbgcolor) {
                                        loadbgcolor();
                                        window.location.reload();
                                    }

                                });
                            }

                        });

                        closer.click(function() {
                            loadprincipalmenu();
                            picker.css("right", "-500px");
                            loadbgcolor();
                        });
                    });
                }

            });

            goparam_btn.click(function() {
                params_menucontainer.css("right", "0");
            });

            goactiv_btn.click(function() {
                activity = acti_menucontainer;
                activity.css("right", "0");
                activity.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"94", cursorborderradius:"3px"});

                loadactivities();

                function loadactivities() {
                    $.post("ajax/_menu/activities.find.menu.php", {bid:bid}, function(findactivities) {
                        activity.html(findactivities);
                        closer = activity.find("#js-close-opened");
                        titlebox = activity.find("#js-menu-one");

                        titlebox.css("position", "fixed").css("z-index", "10");

                        closer.click(function() {
                            loadprincipalmenu();
                            activity.css("right", "-500px");
                            loadactivities();
                        });
                    });
                }
                loadactivities();

            });

        });

    }
    loadprincipalmenu();

});
