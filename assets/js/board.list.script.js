/**
 * Created by Yitzak DEKPEMOU on 16/03/2016.
 */
$(document).ready(function(){

    /* Menu -> ui affiche les options du menu */
    rightpusheropenbtn = $('span#js-open-menu');
    span = $('<span/>').attr('class', 'b-menu-acces nav-toggler toggle-push-right cur-to-point');
    span = span.attr('title', 'Fermer le menu');
    span = span.attr('id', 'js-close-menu');
    finalspan = span.html("<i class='fa fa-times'></i> Fermer");
    rightpusherclosebtn = finalspan;


    color_menucontainer = $('<div/>').attr('class', 'push-menu-backs').attr('id', 'js-backcolor-menu-container');
    params_menucontainer = $('<div/>').attr('class', 'push-menu-backs').attr('id', 'js-params-menu-container');
    acti_menucontainer = $('<div/>').attr('class', 'push-menu-backs').attr('id', 'js-activities-menu-container');
    etiqsbox = $('<div/>').attr('class', 'push-menu-backs').attr('id', 'js-etiquettes-menu-container');
    archsbox = $('<div/>').attr('class', 'push-menu-backs').attr('id', 'js-archivates-menu-container');
    closbox = $('<div/>').attr('class', 'push-menu-backs').attr('id', 'js-boardcloase-menu-container');


    function reload() {
        window.location.reload();
    }

    function loadboard() {

        _wrapper = $('#wrapper');
        _board = $('#board');
        bid = _board.attr("accesskey");

        $.post('ajax/ajax.board.option.php',{bid:bid},function(data){
            _wrapper.find($(_board).html(data));
            _board.niceScroll({cursorcolor:"#B6B6B4", cursorwidth :"10", cursorborder:"#B6B6B4", zindex:"300", cursorborderradius:"3px"});

            // VARIABLES //
            addlist = $("#js-add-list-form");
            addnote = $("#js-add-note form.b-add-note");

            /* Liste */
            addlistBtn = $("#js-list-adder");
            addnoteBtn = $("div#js-add-note");
            selfNote = $("div#js-self-note");
            listTitle = $("div#js-list-title");
            listMenubtn = $("div#js-head-list #js-list-menu");
            addnoteMenubtn = $("div#js-list-sub-menu #js-add-note-listmenu");
            $("div#js-list-note").niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"300", cursorborderradius:"3px"});

            /* Menu de liste */
            addnoteMenubtn.click(function() {
                innerparent_1 = $(this).parent("#js-list-sub-menu");
                innerparent_2 = $(innerparent_1).parent("#js-list-menu");
                innerparent_3 = $(innerparent_2).parent("#js-head-list");
                innerparent_4 = $(innerparent_3).parent("#js-list-note");
                _addnoteBtn = innerparent_4.find("#js-add-note");
                _addnoteBtn.click();

            });

            addlist.hide();
            addnote.hide();
            // Fin VARIABLES //

            // Mini APP //

            /* créer une liste -> boutton qui affiche le formulaire d'ajout de listes */
            addlistBtn.click(function() {
                formlistounwrap = $("#js-add-list-form ");
                listadderbtn = $(this);
                listreseter =  $("#js-list-reseter");
                listinputer = formlistounwrap.find("input#js-add-list-input");
                submitList = formlistounwrap.find("button#js-list-submitter");
                responseBox = formlistounwrap.find("div#js-list-response");

                responseBox.css("color", "#E74C3C");
                responseBox.hide();

                listadderbtn.hide();
                formlistounwrap.fadeIn();
                listinputer.focus();

                submitList.click(function() {
                    listename = listinputer.val();

                    if(listename !== "") {
                        $.post("ajax/_board/ajax.add.liste.php", {listname:listename, bid:bid}, function(newListe) {

                            if(newListe) {
                                loadboard();
                            } else {
                                loadboard();
                            }
                        });
                    } else {
                        responseBox.show().html("<i class='fa fa-times'></i> Vous devez remplir tous les champs");
                    }

                    return false;

                });



                listreseter.focus(function() {
                    formlistounwrap.hide();
                    listadderbtn.fadeIn();
                });

            });

            /* Editer les titres des listes */
            listTitle.click(function() {
                oldName = $(this).attr("about");
                lid = $(this).attr("accesskey");
                /*Quand on clique sur une liste name*/
                function listClicked() {
                    divHtml = $(this).html();
                    reg = new RegExp("<.[^>]*>", "gi" );
                    divHtml = divHtml.replace(reg, "" );
                    editableText = $("<input class='editable_input min-raduised' required='required' />");
                    editableText.val(divHtml);
                    $(this).replaceWith(editableText);
                    editableText.focus();

                    editableText.blur(editableListBlurred);

                }
                /*Quand on clique hors d'une liste name*/
                function editableListBlurred() {
                    html = $(this).val();
                    viewableText = $("<span class='list-title bolder' id='js-list-title'>");
                    viewableText.html(html);
                    $(this).replaceWith(viewableText);

                    if(editableText.blur()) {
                        //  alert(lid+" || "+oldName+" || "+bid);
                        $.post('ajax/_board/ajax.list.upname.php', {bid:bid, lid:lid, html:html, oldName:oldName}, function(upListName){

                            if(upListName) {

                                loadboard();

                            }
                        });

                    }

                    viewableText.click(listClicked);
                }
                $(this).click(listClicked);
                // Fin Edition de lite name //
                //   alert("Cliqué");
            });

            /* créer une note -> boutton qui affiche le formulaire d'ajout de notes */
            addnoteBtn.click(function() {
                $(this).css("margin-top", "10px");
                spantohide = $(this).find("span.b-note-adder");
                formtounwrap = $(this).find("form");
                resetbtn = $(this).find("button[type=reset]");
                textareatofocus = $(this).find("textarea#js-add-note-input");

                //  submitnote = $(this).find("button#js-note-submitter");

                lid = $(this).find("input#js-list-hid").val();
                responseBox = formtounwrap.find("div#js-list-response");
                infobox = formtounwrap.find("#js-infobox");

                responseBox.css("color", "#E74C3C");
                responseBox.hide();
                infobox.hide();

                formtounwrap.fadeIn();
                textareatofocus.focus();
                textareatofocus.elastic().css("height","30px");
                jQuery(textareatofocus).trigger('update');
                spantohide.hide();

                function savenote(){
                    textareatofocus.keyup(function(e){
                        notename = textareatofocus.val();

                        notename = $.trim(notename);
                        if(e.keyCode === 13 && e.shiftKey === false && lid !== "") {
                            if(notename !== "" ) {
                                $.post("ajax/_board/ajax.add.note.php", {lid:lid, bid:bid, notename:notename}, function(){
                                    loadboard();
                                    textareatofocus.val("");
                                    loadboard();
                                });
                            } else {
                                responseBox.show().html("<i class='fa fa-times'></i> Vous devez remplir tous les champs");
                            }
                        }
                    });
                }
                savenote();

                resetbtn.focus(function() {
                    spantohide.fadeIn();
                    formtounwrap.hide();
                });

            });

            /* Note -> qui affiche les options de la note cliquée */
            selfNote.click(function() {
                // Variables //
                leftpusherclosebtn = $('#js-close-note');
                leftpusher = $('.push-note');
                pushed_board = $('#board');
                note_id = $(this).find("input[type=hidden]").val();

                pushercontainer = $('.push-note div#note_options');
                /* Ouvre le pusher */

                leftpusher.css("left", "0px");
                pushed_board.css("left", "335px");
                leftpusher.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"94", cursorborderradius:"3px"});

                /* Ferme le pusher */
                leftpusherclosebtn.click(function() {
                    leftpusher.css("left", "-335px");
                    pushed_board.css("left", "0px");
                    loadboard();
                });

                /* Contenu du pusher */
                function notesucced() {
                    $.post('ajax/ajax.note.option.php',{note_id:note_id},function(data){
                        pushercontainer.html(data);
                        // Variables //
                        spinner = $("<i class='fa fa-spinner fa-spin td-color-lg'>");
                        _note_popsucces = $("#js-pop-alert-succes");
                        _note_popalert = $("#js-pop-alert-errors");
                        _note_popinfos = $("#js-pop-alert-infos");

                        _note_popalert.hide();
                        _note_popinfos.hide();
                        // Fin Variables //

                        // Application css //
                        _note_popsucces.css('left', '0px');
                        _note_popsucces.click(function() {
                            $(this).css('left', '-505px');
                            $(this).fadeOut();
                        });
                        _note_popalert.click(function() {
                            $(this).css('left', '-505px');
                            $(this).fadeOut();
                        });
                        // Fin Css //


                        // Edition de note //
                        /*Quand on clique sur une note*/
                        function noteClicked() {
                            divHtml = $(this).html();
                            reg = new RegExp("<.[^>]*>", "gi" );
                            divHtml = divHtml.replace(reg, "" );
                            editableText = $("<textarea class='editable_tarea min-raduised' required='required' />");
                            editableText.val(divHtml);
                            $(this).replaceWith(editableText);
                            editableText.focus();
                            editableText.elastic().css("height","20px");
                            jQuery(editableText).trigger('update');

                            editableText.blur(editableNoteBlurred);

                        }
                        /*Quand on clique hors d'une note*/
                        function editableNoteBlurred() {
                            html = $(this).val();
                            viewableText = $("<div class='push-edit-note margin-bottoms-zx' id='js-editable-block-note'>");
                            viewableText.html(html);
                            $(this).replaceWith(viewableText);

                            if(editableText.blur()) {
                                spinner.insertAfter(this);
                                $.post('ajax/_notes/ajax.note.upnote.php',{note_id:note_id, html:html, bid:bid},function(upnote){

                                    if(upnote) {

                                        spinner.fadeOut(3000);
                                        notesucced();
                                        loadboard();

                                    } else {

                                        spinner.fadeOut();
                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);

                                    }
                                });

                            }

                            viewableText.click(noteClicked);
                        }
                        $("#js-editable-block-note").click(noteClicked);
                        // Fin Edition de note //


                        // Changement de couleur //
                        $("#js-picker div#js-pick-color").click(function() {
                            note_color = $(this).attr("accesskey");

                            if(note_color !== "") {
                                $.post('ajax/_notes/ajax.color.upnote.php',{note_color:note_color, note_id:note_id, bid:bid},function(upcolor) {

                                    if(upcolor) {

                                        notesucced();
                                        loadboard();

                                    } else {

                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);

                                    }

                                });
                            }

                        });
                        // Fin changement de couleur //


                        // Description de note //
                        /*Quand on clique sur la description*/
                        function descClicked() {
                            divHtml = $(this).html();
                            reg = new RegExp("<.[^>]*>", "gi" );
                            divHtml = divHtml.replace(reg, "" );
                            editableText = $("<textarea class='editable_tarea min-raduised' placeholder='Ecriver votre description.' required='required' />");
                            editableText.val(divHtml);
                            $(this).replaceWith(editableText);
                            editableText.focus();
                            editableText.elastic().css("height","10px");
                            jQuery(editableText).trigger('update');

                            editableText.blur(editableDescBlurred);

                        }
                        /*Quand on clique hors de la description*/
                        function editableDescBlurred() {
                            html = $(this).val();
                            viewableText = $("<div class='push-edit-desc margin-bottoms-zx' id='js-editable-block-desc'>");
                            viewableText.html(html);
                            $(this).replaceWith(viewableText);

                            if(editableText.blur()) {
                                spinner.insertAfter(this);
                                $.post('ajax/_notes/ajax.desc.upnote.php',{note_id:note_id, html:html, bid:bid},function(upDesc){

                                    if(upDesc) {

                                        spinner.fadeOut(3000);
                                        notesucced();
                                        loadboard();

                                    } else {

                                        spinner.fadeOut();
                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);

                                    }
                                });

                            }

                            viewableText.click(descClicked);
                        }
                        $("#js-editable-block-desc").click(descClicked);
                        // Fin description //


                        // Changement de Liste //
                        $("select#js-select-move-note").change(function() {
                            newliste = $(this).val();

                            if(newliste !== "") {
                                $.post('ajax/_notes/ajax.move.upnote.php',{newliste:newliste, note_id:note_id, bid:bid},function(uplist) {

                                    if(uplist) {
                                        notesucced();
                                        leftpusherclosebtn.click();
                                        loadboard();
                                        _note_popsucces.show();
                                        _note_popsucces.fadeOut(5000);
                                    } else {
                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);
                                    }

                                });
                            }

                        });
                        // Fin changement de liste //


                        // Changement de Liste //
                        $("select#js-select-copy-note").change(function() {
                            copieliste = $(this).val();

                            if(copieliste !== "") {
                                $.post('ajax/_notes/ajax.copie.upnote.php',{copieliste:copieliste, note_id:note_id, bid:bid},function(copienote) {

                                    if(copienote) {

                                        notesucced();
                                        loadboard();

                                    } else {

                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);

                                    }

                                });
                            }

                        });
                        // Fin changement de liste //

                        // Archivage de note //
                        $("div#js-note-archiver-btn").click(function() {
                            nid = $(this).attr("accesskey");

                            if(nid !== "") {
                                $.post("ajax/_notes/ajax.archivate.upnote.php", {nid:nid, bid:bid}, function(archivate) {

                                    if(archivate) {
                                        leftpusherclosebtn.click();
                                        loadboard();
                                        //  location.reload();

                                    } else {

                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);

                                    }

                                });
                            } else {

                                _note_popalert.show();
                                _note_popalert.fadeOut(5000);

                            }
                            //  alert(nid);

                        });
                        // Fin archivage //

                    });
                }

                function noteoption(){
                    $.post('ajax/ajax.note.option.php',{note_id:note_id},function(data){
                        pushercontainer.html(data);
                        // Variables //
                        spinner = $("<i class='fa fa-spinner fa-spin td-color-lg'>");
                        _note_popinfos = $("#js-pop-alert-infos");
                        _note_popsucces = $("#js-pop-alert-succes");
                        _note_popalert = $("#js-pop-alert-errors");
                        editablenote = $("#js-editable-block-note");
                        editabledesc = $("#js-editable-block-desc");

                        _note_popsucces.hide();
                        _note_popalert.hide();
                        // Fin Variables //


                        // Application css //
                        _note_popinfos.css('left', '0px');
                        _note_popinfos.click(function() {
                            $(this).css('left', '-335px');
                            $(this).fadeOut();
                        });
                        _note_popsucces.click(function() {
                            $(this).css('left', '-505px');
                            $(this).fadeOut();
                        });
                        _note_popalert.click(function() {
                            $(this).css('left', '-505px');
                            $(this).fadeOut();
                        });
                        // Fin Css //


                        // Edition de note //
                        /*Quand on clique sur une note*/
                        function noteClicked() {
                            divHtml = $(this).html();
                            reg = new RegExp("<.[^>]*>", "gi" );
                            divHtml = divHtml.replace(reg, "" );
                            editableText = $("<textarea class='editable_tarea min-raduised' required='required' />");
                            editableText.val(divHtml);
                            $(this).replaceWith(editableText);
                            editableText.focus();
                            editableText.elastic().css("height","20px");
                            jQuery(editableText).trigger('update');

                            editableText.blur(editableNoteBlurred);

                        }
                        /*Quand on clique hors d'une note*/
                        function editableNoteBlurred() {
                            html = $(this).val();
                            viewableText = $("<div class='push-edit-note margin-bottoms-zx' id='js-editable-block-note'>");
                            viewableText.html(html);
                            $(this).replaceWith(viewableText);

                            if(editableText.blur()) {
                                spinner.insertAfter(this);
                                $.post('ajax/_notes/ajax.note.upnote.php',{note_id:note_id, html:html, bid:bid},function(upnote){

                                    if(upnote) {
                                        spinner.fadeOut(3000);
                                        notesucced();
                                        loadboard();
                                        _note_popsucces.show();
                                        _note_popsucces.fadeOut(5000);
                                    } else {
                                        spinner.fadeOut();
                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);
                                    }
                                });

                            }

                            viewableText.click(noteClicked);
                        }
                        editablenote.click(noteClicked);
                        // Fin Edition de note //


                        // Changement de couleur //
                        $("#js-picker div#js-pick-color").click(function() {
                            note_color = $(this).attr("accesskey");

                            if(note_color !== "") {
                                $.post('ajax/_notes/ajax.color.upnote.php',{note_color:note_color, note_id:note_id, bid:bid},function(upcolor) {

                                    if(upcolor) {

                                        notesucced();
                                        loadboard();
                                        _note_popsucces.show();
                                        _note_popsucces.fadeOut(5000);

                                    } else {

                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);

                                    }

                                });
                            }

                        });
                        // Fin changement de couleur //


                        // Description de note //
                        /*Quand on clique sur la description*/
                        function descClicked() {
                            divHtml = $(this).html();
                            reg = new RegExp("<.[^>]*>", "gi" );
                            divHtml = divHtml.replace(reg, "" );
                            editableText = $("<textarea class='editable_tarea min-raduised' placeholder='Ecriver votre description.' required='required' />");
                            editableText.val(divHtml);
                            $(this).replaceWith(editableText);
                            editableText.focus();
                            editableText.elastic().css("height","10px");
                            jQuery(editableText).trigger('update');

                            editableText.blur(editableDescBlurred);

                        }
                        /*Quand on clique hors de la description*/
                        function editableDescBlurred() {
                            html = $(this).val();
                            viewableText = $("<div class='push-edit-desc margin-bottoms-zx' id='js-editable-block-desc'>");
                            viewableText.html(html);
                            $(this).replaceWith(viewableText);

                            if(editableText.blur()) {
                                spinner.insertAfter(this);
                                $.post('ajax/_notes/ajax.desc.upnote.php',{note_id:note_id, html:html, bid:bid},function(upDesc){

                                    if(upDesc) {

                                        spinner.fadeOut(3000);
                                        notesucced();
                                        loadboard();
                                        _note_popsucces.show();
                                        _note_popsucces.fadeOut(5000);

                                    } else {

                                        spinner.fadeOut();
                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);

                                    }
                                });

                            }
                            viewableText.click(descClicked);
                        }
                        editabledesc.click(descClicked);
                        // Fin description //


                        // Changement de Liste //
                        $("select#js-select-move-note").change(function() {
                            newliste = $(this).val();

                            if(newliste !== "") {
                                $.post('ajax/_notes/ajax.move.upnote.php',{newliste:newliste, note_id:note_id, bid:bid},function(uplist) {

                                    if(uplist) {

                                        notesucced();
                                        leftpusherclosebtn.click();
                                        loadboard();
                                        _note_popsucces.show();
                                        _note_popsucces.fadeOut(5000);

                                    } else {

                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);

                                    }

                                });
                            }

                        });
                        // Fin changement de liste //


                        // Copie de note //
                        $("select#js-select-copy-note").change(function() {
                            copieliste = $(this).val();

                            if(copieliste !== "") {
                                $.post('ajax/_notes/ajax.copie.upnote.php',{copieliste:copieliste, note_id:note_id, bid:bid},function(copienote) {

                                    if(copienote) {

                                        notesucced();
                                        loadboard();
                                        _note_popsucces.show();
                                        _note_popsucces.fadeOut(5000);

                                    } else {

                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);

                                    }

                                });
                            }

                        });
                        // Fin copie de note //


                        // Archivage de note //
                        $("div#js-note-archiver-btn").click(function() {
                            nid = $(this).attr("accesskey");

                            if(nid !== "") {
                                $.post("ajax/_notes/ajax.archivate.upnote.php", {nid:nid, bid:bid}, function(archivate) {

                                    if(archivate) {
                                        leftpusherclosebtn.click();
                                        loadboard();
                                        //  location.reload();

                                    } else {

                                        _note_popalert.show();
                                        _note_popalert.fadeOut(5000);

                                    }

                                });
                            } else {

                                _note_popalert.show();
                                _note_popalert.fadeOut(5000);

                            }
                            //  alert(nid);

                        });
                        // Fin archivage //

                    });

                }
                noteoption();

            });

            // Fin Mini APP //

        });
    }
    loadboard();

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
            color_menucontainer.appendTo($("#wrap"));
            params_menucontainer.appendTo($("#wrap"));
            acti_menucontainer.appendTo($("#wrap"));
            etiqsbox.appendTo($("#wrap"));
            archsbox.appendTo($("#wrap"));
            closbox.appendTo($("#wrap"));

            /* Récupération de quelques activités */
            some_activities = $("#js-some-activities");
            function someActivities() {
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
            }
            setInterval(someActivities(), 3000);
            someActivities();

            /* Menu de changement de couleur de fond */
            goback_colorbtn.click(function() {
                picker = color_menucontainer;
                picker.css('right', '0');
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
                                        loadboard();
                                        reload();
                                    }

                                });
                            }

                        });

                        closer.click(function() {
                            loadbgcolor();
                            picker.css("right", "-355px");
                        });
                    });
                }

            });

            /* Menu pour aller au paramètres */
            goparam_btn.click(function() {
                parameters = params_menucontainer;
                parameters.css("right", "0");
                parameters.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"94", cursorborderradius:"3px"});

                function loadparams(){
                    $.post("ajax/_menu/ajax.params.menu.php", function(_parameters) {
                        parameters.html(_parameters);
                        closer = parameters.find("#js-close-opened");
                        titlebox = parameters.find("#js-menu-one");

                        titlebox.css("position", "fixed").css("z-index", "10");

                        // Variables //
                        goEtiqs = $("#js-prm-etiqs-btn");
                        goArchivs = $("#js-prm-archs-btn");
                        goClose = $("#js-prm-close-btn");

                        goEtiqs.click(function() {
                            etiqsbox.css('right', '0');
                            etiqsbox.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"94", cursorborderradius:"3px"});
                            function aboutetiquettes() {
                                $.post('ajax/_menu/params/etiquettes.menu.php', {bid:bid}, function(gotEtiquettes) {
                                    etiqsbox.html(gotEtiquettes);
                                    closer = etiqsbox.find("#js-close-opened");
                                    titlebox = etiqsbox.find("#js-menu-one");

                                    titlebox.css("position", "fixed").css("z-index", "10");

                                    $('#filterForm :checkbox').on('click',function() {

                                        if($(this).parent().hasClass("et-box-checked")) {
                                            $(this).parent().removeClass("et-box-checked");
                                        } else {
                                            $(this).parent().addClass("et-box-checked");
                                        }

                                        var exocolor = $('#filterForm input:checked').map(function() {
                                            return this.value;
                                        }).get();
                                        if(exocolor.length === 0) {
                                            loadboard();
                                        } else{
                                            function reloadBoardBy() {
                                                $.post("ajax/load.board.by.color.notes.options.php", {exocolor:exocolor, bid:bid}, function(reloadBoard) {
                                                    _wrapper.find($(_board).html(reloadBoard));
                                                    _board.niceScroll({cursorcolor:"#B6B6B4", cursorwidth :"10", cursorborder:"#B6B6B4", zindex:"300", cursorborderradius:"3px"});

                                                    // VARIABLES //
                                                    addlist = $("#js-add-list-form");
                                                    addnote = $("#js-add-note form.b-add-note");

                                                    /* Liste */
                                                    addlistBtn = $("#js-list-adder");
                                                    addnoteBtn = $("div#js-add-note");
                                                    selfNote = $("div#js-self-note");
                                                    listTitle = $("div#js-list-title");
                                                    listMenubtn = $("div#js-head-list #js-list-menu");
                                                    addnoteMenubtn = $("div#js-list-sub-menu #js-add-note-listmenu");
                                                    $("div#js-list-note").niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"300", cursorborderradius:"3px"});

                                                    /* Menu de liste */
                                                    addnoteMenubtn.click(function() {
                                                        innerparent_1 = $(this).parent("#js-list-sub-menu");
                                                        innerparent_2 = $(innerparent_1).parent("#js-list-menu");
                                                        innerparent_3 = $(innerparent_2).parent("#js-head-list");
                                                        innerparent_4 = $(innerparent_3).parent("#js-list-note");
                                                        _addnoteBtn = innerparent_4.find("#js-add-note");
                                                        _addnoteBtn.click();

                                                    });

                                                    addlist.hide();
                                                    addnote.hide();
                                                    // Fin VARIABLES //

                                                    // Mini APP //

                                                    /* créer une liste -> boutton qui affiche le formulaire d'ajout de listes */
                                                    addlistBtn.click(function() {
                                                        formlistounwrap = $("#js-add-list-form ");
                                                        listadderbtn = $(this);
                                                        listreseter =  $("#js-list-reseter");
                                                        listinputer = formlistounwrap.find("input#js-add-list-input");
                                                        submitList = formlistounwrap.find("button#js-list-submitter");
                                                        responseBox = formlistounwrap.find("div#js-list-response");

                                                        responseBox.css("color", "#E74C3C");
                                                        responseBox.hide();

                                                        listadderbtn.hide();
                                                        formlistounwrap.fadeIn();
                                                        listinputer.focus();

                                                        submitList.click(function() {
                                                            listename = listinputer.val();

                                                            if(listename !== "") {
                                                                $.post("ajax/_board/ajax.add.liste.php", {listname:listename, bid:bid}, function(newListe) {

                                                                    if(newListe) {
                                                                        reloadBoardBy();
                                                                    } else {
                                                                        reloadBoardBy();
                                                                    }
                                                                });
                                                            } else {
                                                                responseBox.show().html("<i class='fa fa-times'></i> Vous devez remplir tous les champs");
                                                            }

                                                            return false;

                                                        });



                                                        listreseter.focus(function() {
                                                            formlistounwrap.hide();
                                                            listadderbtn.fadeIn();
                                                        });

                                                    });

                                                    /* Editer les titres des listes */
                                                    listTitle.click(function() {
                                                        oldName = $(this).attr("about");
                                                        lid = $(this).attr("accesskey");
                                                        /*Quand on clique sur une liste name*/
                                                        function listClicked() {
                                                            divHtml = $(this).html();
                                                            reg = new RegExp("<.[^>]*>", "gi" );
                                                            divHtml = divHtml.replace(reg, "" );
                                                            editableText = $("<input class='editable_input min-raduised' required='required' />");
                                                            editableText.val(divHtml);
                                                            $(this).replaceWith(editableText);
                                                            editableText.focus();

                                                            editableText.blur(editableListBlurred);

                                                        }
                                                        /*Quand on clique hors d'une liste name*/
                                                        function editableListBlurred() {
                                                            html = $(this).val();
                                                            viewableText = $("<span class='list-title bolder' id='js-list-title'>");
                                                            viewableText.html(html);
                                                            $(this).replaceWith(viewableText);

                                                            if(editableText.blur()) {
                                                                //  alert(lid+" || "+oldName+" || "+bid);
                                                                $.post('ajax/_board/ajax.list.upname.php', {bid:bid, lid:lid, html:html, oldName:oldName}, function(upListName){

                                                                    if(upListName) {

                                                                        reloadBoardBy();

                                                                    }
                                                                });

                                                            }

                                                            viewableText.click(listClicked);
                                                        }
                                                        $(this).click(listClicked);
                                                        // Fin Edition de lite name //
                                                        //   alert("Cliqué");
                                                    });

                                                    /* créer une note -> boutton qui affiche le formulaire d'ajout de notes */
                                                    addnoteBtn.click(function() {
                                                        $(this).css("margin-top", "10px");
                                                        spantohide = $(this).find("span.b-note-adder");
                                                        formtounwrap = $(this).find("form");
                                                        resetbtn = $(this).find("button[type=reset]");
                                                        textareatofocus = $(this).find("textarea#js-add-note-input");

                                                        //  submitnote = $(this).find("button#js-note-submitter");

                                                        lid = $(this).find("input#js-list-hid").val();
                                                        responseBox = formtounwrap.find("div#js-list-response");
                                                        infobox = formtounwrap.find("#js-infobox");

                                                        responseBox.css("color", "#E74C3C");
                                                        responseBox.hide();
                                                        infobox.hide();

                                                        formtounwrap.fadeIn();
                                                        textareatofocus.focus();
                                                        textareatofocus.elastic().css("height","30px");
                                                        jQuery(textareatofocus).trigger('update');
                                                        spantohide.hide();

                                                        function savenote(){
                                                            textareatofocus.keyup(function(e){
                                                                notename = textareatofocus.val();

                                                                notename = $.trim(notename);
                                                                if(e.keyCode === 13 && e.shiftKey === false && lid !== "") {
                                                                    if(notename !== "" ) {
                                                                        $.post("ajax/_board/ajax.add.note.php", {lid:lid, bid:bid, notename:notename}, function(){
                                                                            reloadBoardBy();
                                                                            textareatofocus.val("");
                                                                            reloadBoardBy();
                                                                        });
                                                                    } else {
                                                                        responseBox.show().html("<i class='fa fa-times'></i> Vous devez remplir tous les champs");
                                                                    }
                                                                }
                                                            });
                                                        }
                                                        savenote();

                                                        resetbtn.focus(function() {
                                                            spantohide.fadeIn();
                                                            formtounwrap.hide();
                                                        });

                                                    });

                                                    /* Note -> qui affiche les options de la note cliquée */
                                                    selfNote.click(function() {
                                                        // Variables //
                                                        leftpusherclosebtn = $('#js-close-note');
                                                        leftpusher = $('.push-note');
                                                        pushed_board = $('#board');
                                                        note_id = $(this).find("input[type=hidden]").val();

                                                        pushercontainer = $('.push-note div#note_options');
                                                        /* Ouvre le pusher */

                                                        leftpusher.css("left", "0px");
                                                        pushed_board.css("left", "335px");
                                                        leftpusher.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"94", cursorborderradius:"3px"});

                                                        /* Ferme le pusher */
                                                        leftpusherclosebtn.click(function() {
                                                            leftpusher.css("left", "-335px");
                                                            pushed_board.css("left", "0px");
                                                            reloadBoardBy();
                                                        });

                                                        /* Contenu du pusher */
                                                        function notesucced() {
                                                            $.post('ajax/ajax.note.option.php',{note_id:note_id},function(data){
                                                                pushercontainer.html(data);
                                                                // Variables //
                                                                spinner = $("<i class='fa fa-spinner fa-spin td-color-lg'>");
                                                                _note_popsucces = $("#js-pop-alert-succes");
                                                                _note_popalert = $("#js-pop-alert-errors");
                                                                _note_popinfos = $("#js-pop-alert-infos");

                                                                _note_popalert.hide();
                                                                _note_popinfos.hide();
                                                                // Fin Variables //

                                                                // Application css //
                                                                _note_popsucces.css('left', '0px');
                                                                _note_popsucces.click(function() {
                                                                    $(this).css('left', '-505px');
                                                                    $(this).fadeOut();
                                                                });
                                                                _note_popalert.click(function() {
                                                                    $(this).css('left', '-505px');
                                                                    $(this).fadeOut();
                                                                });
                                                                // Fin Css //


                                                                // Edition de note //
                                                                /*Quand on clique sur une note*/
                                                                function noteClicked() {
                                                                    divHtml = $(this).html();
                                                                    reg = new RegExp("<.[^>]*>", "gi" );
                                                                    divHtml = divHtml.replace(reg, "" );
                                                                    editableText = $("<textarea class='editable_tarea min-raduised' required='required' />");
                                                                    editableText.val(divHtml);
                                                                    $(this).replaceWith(editableText);
                                                                    editableText.focus();
                                                                    editableText.elastic().css("height","20px");
                                                                    jQuery(editableText).trigger('update');

                                                                    editableText.blur(editableNoteBlurred);

                                                                }
                                                                /*Quand on clique hors d'une note*/
                                                                function editableNoteBlurred() {
                                                                    html = $(this).val();
                                                                    viewableText = $("<div class='push-edit-note margin-bottoms-zx' id='js-editable-block-note'>");
                                                                    viewableText.html(html);
                                                                    $(this).replaceWith(viewableText);

                                                                    if(editableText.blur()) {
                                                                        spinner.insertAfter(this);
                                                                        $.post('ajax/_notes/ajax.note.upnote.php',{note_id:note_id, html:html, bid:bid},function(upnote){

                                                                            if(upnote) {

                                                                                spinner.fadeOut(3000);
                                                                                notesucced();
                                                                                reloadBoardBy();

                                                                            } else {

                                                                                spinner.fadeOut();
                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);

                                                                            }
                                                                        });

                                                                    }

                                                                    viewableText.click(noteClicked);
                                                                }
                                                                $("#js-editable-block-note").click(noteClicked);
                                                                // Fin Edition de note //


                                                                // Changement de couleur //
                                                                $("#js-picker div#js-pick-color").click(function() {
                                                                    note_color = $(this).attr("accesskey");

                                                                    if(note_color !== "") {
                                                                        $.post('ajax/_notes/ajax.color.upnote.php',{note_color:note_color, note_id:note_id, bid:bid},function(upcolor) {

                                                                            if(upcolor) {

                                                                                notesucced();
                                                                                reloadBoardBy();

                                                                            } else {

                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);

                                                                            }

                                                                        });
                                                                    }

                                                                });
                                                                // Fin changement de couleur //


                                                                // Description de note //
                                                                /*Quand on clique sur la description*/
                                                                function descClicked() {
                                                                    divHtml = $(this).html();
                                                                    reg = new RegExp("<.[^>]*>", "gi" );
                                                                    divHtml = divHtml.replace(reg, "" );
                                                                    editableText = $("<textarea class='editable_tarea min-raduised' placeholder='Ecriver votre description.' required='required' />");
                                                                    editableText.val(divHtml);
                                                                    $(this).replaceWith(editableText);
                                                                    editableText.focus();
                                                                    editableText.elastic().css("height","10px");
                                                                    jQuery(editableText).trigger('update');

                                                                    editableText.blur(editableDescBlurred);

                                                                }
                                                                /*Quand on clique hors de la description*/
                                                                function editableDescBlurred() {
                                                                    html = $(this).val();
                                                                    viewableText = $("<div class='push-edit-desc margin-bottoms-zx' id='js-editable-block-desc'>");
                                                                    viewableText.html(html);
                                                                    $(this).replaceWith(viewableText);

                                                                    if(editableText.blur()) {
                                                                        spinner.insertAfter(this);
                                                                        $.post('ajax/_notes/ajax.desc.upnote.php',{note_id:note_id, html:html, bid:bid},function(upDesc){

                                                                            if(upDesc) {

                                                                                spinner.fadeOut(3000);
                                                                                notesucced();
                                                                                reloadBoardBy();

                                                                            } else {

                                                                                spinner.fadeOut();
                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);

                                                                            }
                                                                        });

                                                                    }

                                                                    viewableText.click(descClicked);
                                                                }
                                                                $("#js-editable-block-desc").click(descClicked);
                                                                // Fin description //


                                                                // Changement de Liste //
                                                                $("select#js-select-move-note").change(function() {
                                                                    newliste = $(this).val();

                                                                    if(newliste !== "") {
                                                                        $.post('ajax/_notes/ajax.move.upnote.php',{newliste:newliste, note_id:note_id, bid:bid},function(uplist) {

                                                                            if(uplist) {
                                                                                notesucced();
                                                                                leftpusherclosebtn.click();
                                                                                reloadBoardBy();
                                                                                _note_popsucces.show();
                                                                                _note_popsucces.fadeOut(5000);
                                                                            } else {
                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);
                                                                            }

                                                                        });
                                                                    }

                                                                });
                                                                // Fin changement de liste //


                                                                // Changement de Liste //
                                                                $("select#js-select-copy-note").change(function() {
                                                                    copieliste = $(this).val();

                                                                    if(copieliste !== "") {
                                                                        $.post('ajax/_notes/ajax.copie.upnote.php',{copieliste:copieliste, note_id:note_id, bid:bid},function(copienote) {

                                                                            if(copienote) {

                                                                                notesucced();
                                                                                reloadBoardBy();

                                                                            } else {

                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);

                                                                            }

                                                                        });
                                                                    }

                                                                });
                                                                // Fin changement de liste //

                                                                // Archivage de note //
                                                                $("div#js-note-archiver-btn").click(function() {
                                                                    nid = $(this).attr("accesskey");

                                                                    if(nid !== "") {
                                                                        $.post("ajax/_notes/ajax.archivate.upnote.php", {nid:nid, bid:bid}, function(archivate) {

                                                                            if(archivate) {
                                                                                leftpusherclosebtn.click();
                                                                                reloadBoardBy();
                                                                                //  location.reload();

                                                                            } else {

                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);

                                                                            }

                                                                        });
                                                                    } else {

                                                                        _note_popalert.show();
                                                                        _note_popalert.fadeOut(5000);

                                                                    }
                                                                    //  alert(nid);

                                                                });
                                                                // Fin archivage //

                                                            });
                                                        }

                                                        function noteoption(){
                                                            $.post('ajax/ajax.note.option.php',{note_id:note_id},function(data){
                                                                pushercontainer.html(data);
                                                                // Variables //
                                                                spinner = $("<i class='fa fa-spinner fa-spin td-color-lg'>");
                                                                _note_popinfos = $("#js-pop-alert-infos");
                                                                _note_popsucces = $("#js-pop-alert-succes");
                                                                _note_popalert = $("#js-pop-alert-errors");
                                                                editablenote = $("#js-editable-block-note");
                                                                editabledesc = $("#js-editable-block-desc");

                                                                _note_popsucces.hide();
                                                                _note_popalert.hide();
                                                                // Fin Variables //


                                                                // Application css //
                                                                _note_popinfos.css('left', '0px');
                                                                _note_popinfos.click(function() {
                                                                    $(this).css('left', '-335px');
                                                                    $(this).fadeOut();
                                                                });
                                                                _note_popsucces.click(function() {
                                                                    $(this).css('left', '-505px');
                                                                    $(this).fadeOut();
                                                                });
                                                                _note_popalert.click(function() {
                                                                    $(this).css('left', '-505px');
                                                                    $(this).fadeOut();
                                                                });
                                                                // Fin Css //


                                                                // Edition de note //
                                                                /*Quand on clique sur une note*/
                                                                function noteClicked() {
                                                                    divHtml = $(this).html();
                                                                    reg = new RegExp("<.[^>]*>", "gi" );
                                                                    divHtml = divHtml.replace(reg, "" );
                                                                    editableText = $("<textarea class='editable_tarea min-raduised' required='required' />");
                                                                    editableText.val(divHtml);
                                                                    $(this).replaceWith(editableText);
                                                                    editableText.focus();
                                                                    editableText.elastic().css("height","20px");
                                                                    jQuery(editableText).trigger('update');

                                                                    editableText.blur(editableNoteBlurred);

                                                                }
                                                                /*Quand on clique hors d'une note*/
                                                                function editableNoteBlurred() {
                                                                    html = $(this).val();
                                                                    viewableText = $("<div class='push-edit-note margin-bottoms-zx' id='js-editable-block-note'>");
                                                                    viewableText.html(html);
                                                                    $(this).replaceWith(viewableText);

                                                                    if(editableText.blur()) {
                                                                        spinner.insertAfter(this);
                                                                        $.post('ajax/_notes/ajax.note.upnote.php',{note_id:note_id, html:html, bid:bid},function(upnote){

                                                                            if(upnote) {
                                                                                spinner.fadeOut(3000);
                                                                                notesucced();
                                                                                reloadBoardBy();
                                                                                _note_popsucces.show();
                                                                                _note_popsucces.fadeOut(5000);
                                                                            } else {
                                                                                spinner.fadeOut();
                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);
                                                                            }
                                                                        });

                                                                    }

                                                                    viewableText.click(noteClicked);
                                                                }
                                                                editablenote.click(noteClicked);
                                                                // Fin Edition de note //


                                                                // Changement de couleur //
                                                                $("#js-picker div#js-pick-color").click(function() {
                                                                    note_color = $(this).attr("accesskey");

                                                                    if(note_color !== "") {
                                                                        $.post('ajax/_notes/ajax.color.upnote.php',{note_color:note_color, note_id:note_id, bid:bid},function(upcolor) {

                                                                            if(upcolor) {

                                                                                notesucced();
                                                                                reloadBoardBy();
                                                                                _note_popsucces.show();
                                                                                _note_popsucces.fadeOut(5000);

                                                                            } else {

                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);

                                                                            }

                                                                        });
                                                                    }

                                                                });
                                                                // Fin changement de couleur //


                                                                // Description de note //
                                                                /*Quand on clique sur la description*/
                                                                function descClicked() {
                                                                    divHtml = $(this).html();
                                                                    reg = new RegExp("<.[^>]*>", "gi" );
                                                                    divHtml = divHtml.replace(reg, "" );
                                                                    editableText = $("<textarea class='editable_tarea min-raduised' placeholder='Ecriver votre description.' required='required' />");
                                                                    editableText.val(divHtml);
                                                                    $(this).replaceWith(editableText);
                                                                    editableText.focus();
                                                                    editableText.elastic().css("height","10px");
                                                                    jQuery(editableText).trigger('update');

                                                                    editableText.blur(editableDescBlurred);

                                                                }
                                                                /*Quand on clique hors de la description*/
                                                                function editableDescBlurred() {
                                                                    html = $(this).val();
                                                                    viewableText = $("<div class='push-edit-desc margin-bottoms-zx' id='js-editable-block-desc'>");
                                                                    viewableText.html(html);
                                                                    $(this).replaceWith(viewableText);

                                                                    if(editableText.blur()) {
                                                                        spinner.insertAfter(this);
                                                                        $.post('ajax/_notes/ajax.desc.upnote.php',{note_id:note_id, html:html, bid:bid},function(upDesc){

                                                                            if(upDesc) {

                                                                                spinner.fadeOut(3000);
                                                                                notesucced();
                                                                                reloadBoardBy();
                                                                                _note_popsucces.show();
                                                                                _note_popsucces.fadeOut(5000);

                                                                            } else {

                                                                                spinner.fadeOut();
                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);

                                                                            }
                                                                        });

                                                                    }
                                                                    viewableText.click(descClicked);
                                                                }
                                                                editabledesc.click(descClicked);
                                                                // Fin description //


                                                                // Changement de Liste //
                                                                $("select#js-select-move-note").change(function() {
                                                                    newliste = $(this).val();

                                                                    if(newliste !== "") {
                                                                        $.post('ajax/_notes/ajax.move.upnote.php',{newliste:newliste, note_id:note_id, bid:bid},function(uplist) {

                                                                            if(uplist) {

                                                                                notesucced();
                                                                                leftpusherclosebtn.click();
                                                                                reloadBoardBy();
                                                                                _note_popsucces.show();
                                                                                _note_popsucces.fadeOut(5000);

                                                                            } else {

                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);

                                                                            }

                                                                        });
                                                                    }

                                                                });
                                                                // Fin changement de liste //


                                                                // Copie de note //
                                                                $("select#js-select-copy-note").change(function() {
                                                                    copieliste = $(this).val();

                                                                    if(copieliste !== "") {
                                                                        $.post('ajax/_notes/ajax.copie.upnote.php',{copieliste:copieliste, note_id:note_id, bid:bid},function(copienote) {

                                                                            if(copienote) {

                                                                                notesucced();
                                                                                reloadBoardBy();
                                                                                _note_popsucces.show();
                                                                                _note_popsucces.fadeOut(5000);

                                                                            } else {

                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);

                                                                            }

                                                                        });
                                                                    }

                                                                });
                                                                // Fin copie de note //


                                                                // Archivage de note //
                                                                $("div#js-note-archiver-btn").click(function() {
                                                                    nid = $(this).attr("accesskey");

                                                                    if(nid !== "") {
                                                                        $.post("ajax/_notes/ajax.archivate.upnote.php", {nid:nid, bid:bid}, function(archivate) {

                                                                            if(archivate) {
                                                                                leftpusherclosebtn.click();
                                                                                reloadBoardBy();
                                                                                //  location.reload();

                                                                            } else {

                                                                                _note_popalert.show();
                                                                                _note_popalert.fadeOut(5000);

                                                                            }

                                                                        });
                                                                    } else {

                                                                        _note_popalert.show();
                                                                        _note_popalert.fadeOut(5000);

                                                                    }
                                                                    //  alert(nid);

                                                                });
                                                                // Fin archivage //

                                                            });

                                                        }
                                                        noteoption();

                                                    });

                                                    // Fin Mini APP //

                                                });

                                            }
                                            reloadBoardBy();
                                        }

                                    });



                                    closer.click(function() {
                                        etiqsbox.css("right", "-500px");
                                        loadparams();
                                    });
                                });
                            }
                            aboutetiquettes();
                        });

                        goArchivs.click(function() {
                            archsbox.css('right', '0');
                            archsbox.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"94", cursorborderradius:"3px"});
                            function aboutarchives() {
                                $.post('ajax/_menu/params/archivates_elmt.menu.php', {bid:bid}, function(gotArchives) {
                                    archsbox.html(gotArchives);
                                    closer = archsbox.find("#js-close-opened");
                                    titlebox = archsbox.find("#js-menu-one");

                                    titlebox.css("position", "fixed").css("z-index", "10");

                                    closer.click(function() {
                                        archsbox.css("right", "-500px");
                                        loadparams();
                                    });
                                });
                            }
                            aboutarchives();
                        });

                        goClose.click(function() {
                            alert("Fermer le tableau");
                        });

                        // All Params Apps //

                        // End Params Apps //

                        closer.click(function() {
                            parameters.css("right", "-500px");
                            loadparams();
                        });

                    });
                }
                loadparams();

            });

            /* Menu pour aller au activités */
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
                            activity.css("right", "-500px");
                            loadactivities();
                        });
                    });
                }
                setInterval(loadactivities(), 3000);
                loadactivities();

            });



        });

    }


    rightpusheropenbtn.click(function() {

        $(this).hide();
        rightpusherclosebtn.fadeIn();
        rightpusherclosebtn.appendTo($("div#js-board-menu"));

        rightpusher = $('.push-menu');
        pushed_board = $('#board');
        globalcontainer = $("#wrapper");

        rightpusher.css("right", "0px");
        pushed_board.css("right", "335px");
        loadprincipalmenu();

        rightpusher.niceScroll({cursorcolor:"#B6B6B4", cursorborder:"#B6B6B4", zindex:"90", cursorborderradius:"3px"});

        rightpusherclosebtn.click(function() {
            $(this).remove();
            color_menucontainer.css("right", "-500px");
            params_menucontainer.css("right", "-500px");
            acti_menucontainer.css("right", "-500px");
            etiqsbox.css("right", "-500px");
            archsbox.css("right", "-500px");
            closbox.css("right", "-500px");

            rightpusher.css("right", "-335px");
            pushed_board.css("right", "0px");

            rightpusheropenbtn.fadeIn();
            color_menucontainer.remove();
            params_menucontainer.remove();
            acti_menucontainer.remove();
            etiqsbox.remove();
            archsbox.remove();
            closbox.remove();
            loadboard();

        });

    });

});
