/**
 * Created by Yitzak DEKPEMOU on 28/04/2016.
 */
(function($){
    var o = {
        message : "Vous pouvez glisser un fichier image ici",
        script  : "ajax/_notes/ajax.file.upload.parser.php",
        clone   : true,
        complete: function(json) {
            return false;
        }
    }

    $.fn.dropfile = function(oo) {
        replace = false;
        if(oo) $.extend(o,oo);
        this.each(function() {
            instruction = $("<span />").addClass("uploadInstruction").append(o.message).appendTo(this);
            progress = $("<span />").addClass("uploadProgress").appendTo(this);
            $(this).bind({
                dragenter : function(e){
                    e.preventDefault();
                },
                dragover : function(e){
                    e.preventDefault();
                    $(this).addClass("uploadHover");
                },
                dragleave : function(e){
                    e.preventDefault();
                    $(this).removeClass("uploadHover");
                }
            });
            this.addEventListener('drop', function(e) {
                e.preventDefault();
                files = e.dataTransfer.files;
                if($(this).data('value')) {
                    replace =  true;
                }
                upload(files, $(this), 0);
            }, false);
        });

        function upload(files, area, index) {
            file = files[index];
            if(index > 0 && o.clone) {
                area = area.clone().html('').insertAfter(area).dropfile(o);
                area.data('value', null);
            }
            xhr = new XMLHttpRequest();

            /* Events */
            xhr.addEventListener('load', function(e) {
                json = jQuery.parseJSON(e.target.responseText);
                area.removeClass("uploadHover");
                instruction.css('display', 'none');
                progress.css({width: 0});
                if(index < files.length - 1) {
                    upload(files, area, index+1);
                }

                if(json.error) {
                    alert(json.error);
                    return false;
                }
                if(o.complete(json)) {
                    return true;
                }
                if(o.clone && !replace && index == files.length - 1) {
                    area.clone().html('').insertAfter(area).dropfile(o);
                }
                area.data('value', json.name);
                area.append(json.content);
            }, false);
            xhr.upload.addEventListener('progress', function(e) {
                if(e.lengthComputable) {
                    perc = (Math.round(e.loaded/e.total) * 100) + '%';
                    progress.css({width:perc});
                }
            }, false);
            xhr.open("post", o.script, true);
            xhr.setRequestHeader("x-file-type", file.type);
            xhr.setRequestHeader("x-file-size", file.size);
            xhr.setRequestHeader("x-file-name", file.name);
            for(var i in area.data()) {
                if(typeof area.data(i) !== 'object') {
                    xhr.setRequestHeader('x-param-'+i, area.data(i));
                }
            }
            xhr.send(file);
        }
        return this;
    }
})(jQuery);