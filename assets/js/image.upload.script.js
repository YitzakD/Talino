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
            target:        '#errormes',
            beforeSubmit:  showRequest,
            success:       showResponse,

            url:       'ajax/ajax.avatar.upload.php',
            type:      'post',
            clearForm: true,
            resetForm: true
        };
        $('#set_img').change(function() {
            $('#progress').show();
        });

        $('#avatarForm').submit(function() {
            $(this).ajaxSubmit(options);
            return false;
        });

        function showRequest(formData, jqForm, options) {
            var queryString = $.param(formData);
            return true;
        }

        function showResponse(responseText, statusText, xhr, $form) {}

    })();

});
