/**
 * Created by Yitzak DEKPEMOU on 23/04/2016.
 */
$(document).ready(function(){
    function loadUserActivities() {
        allActivitiesBox = $("#js-load-activities-in-profile");
        uid = $(allActivitiesBox).attr("accesskey");

        $.post("ajax/_profile/ajax.all.u.activities.profile.php", {uid:uid}, function(datas) {
            allActivitiesBox.html(datas);

        });

    }
    setInterval(loadUserActivities,1200000);
    loadUserActivities();
});