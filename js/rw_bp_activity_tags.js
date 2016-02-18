

jQuery(document).ready(function($) {
    var data_post_id;
    var data_post_nonces;
    jQuery(document).on('click', '.add-activity-tag', function () {
        var button = $(this);
        data_post_id = button.attr('data-post-id');
        data_post_nonces = button.attr('data-post-nonces');
        $( "#dialog" ).dialog({
            position: { my: "center", at: "center", of: "#activity-stream" },
            modal: true
        });
    });

    jQuery(document).on('click', '.adas', function () {
alert("1");
        var button = $(".adas");
        button.addClass( 'loading');
        var data = {
            'action': 'add_tag_activity',
            'data-post-nonces' : data_post_nonces,
            'data-post-id' :data_post_id
        };
        alert("2");

        jQuery.post("/wp-admin/admin-ajax.php", data, function (response) {

//            button.removeClass('loading');
//            button.removeClass('notpinned');
//            button.addClass('pinned');
//            $("div.buddypress-sa").remove();
//            $(".activity-tag-list").append( response );
            alert("3");
//            $("div#group-description div.widget_sticky_acivity").append( response );
        });
        return false;
    });

});

