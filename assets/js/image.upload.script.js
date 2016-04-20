/**
 * Created by Yitzak DEKPEMOU
 */
$(document).ready(function(){
    $('#progress').hide();
    (function() {

        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');

        $('#avatarForm').ajaxForm({
            beforeSend: function() {
                status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            success: function() {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            complete: function(xhr) {
                $('#progress').hide();
                status.html(xhr.responseText);
                location.reload();
            }
        });

        var options = {
            target:        '#errormes',   // target element(s) to be updated with server response
            beforeSubmit:  showRequest,  // pre-submit callback
            success:       showResponse,  // post-submit callback

            // other available options:
            url:       'ajax/avatar.upload.php',         // override for form's 'action' attribute
            type:      'post',        // 'get' or 'post', override for form's 'method' attribute
            //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
            clearForm: true,        // clear all form fields after successful submit
            resetForm: true        // reset the form after successful submit

            // $.ajax options can be used here too, for example:
            //timeout:   3000
        };
        $('#set_img').change(function() {
            $('#progress').show();
        });

        $('#avatarForm').submit(function() {
            $(this).ajaxSubmit(options);

            // !!! Important !!!
            // always return false to prevent standard browser submit and page navigation
            return false;
        });

        // pre-submit callback
        function showRequest(formData, jqForm, options) {
            var queryString = $.param(formData);
            return true;
        }

        // post-submit callback
        function showResponse(responseText, statusText, xhr, $form) {}

    })();

});
