$(document).ready(function(){

    progressBar = {

        countElmt : 0,

        loadedElmt : 0,

        init : function(){

            var that = this;

            this.countElmt = $('img').length;

            // Creation et ajout de la progresse barre
            var $progressBarContainer = $('<div/>').attr('id', 'progressContainer');

            $progressBarContainer.append($('<div/>').attr('id', 'bar'));

            $progressBarContainer.appendTo($('body'));

            // Ajout du contenaur d'element
            var $container = $('<div/>').attr('id', 'progressElement');

            $container.appendTo($('body'));

            // Parcours des elements à prendre en compte pour le chargement
            $('img').each(function(){

                $('<img/>').attr('src', $(this).attr('src')).load('load error', function(){

                    that.loadedElmt++;

                    that.updateBar();

                })

                .appendTo($container);

            });

        },

        updateBar : function(){

            $('#bar').stop().animate({

                'width' : (progressBar.loadedElmt/progressBar.countElmt)*100 + '%'

            }, function(){

                if(progressBar.loadedElmt == progressBar.countElmt){

                    setTimeout(function(){

                        $('#progressContainer').animate({

                            'top' : '-8px'

                        }, function(){

                            $('#progressContainer').remove();

                            $('#progressElement').remove();

                        })

                    }, 1000);

                }

            });

        }

    };

    progressBar.init();

});
