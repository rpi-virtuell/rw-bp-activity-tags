

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

        return false;
    });

    jQuery(document).on('click', '.adas', function () {
        var button = $(".adas");
        button.addClass( 'loading');
        var tags = $(".data-post-tags").val();
        var data = {
            'action': 'add_tag_activity',
            'data-post-nonces' : data_post_nonces,
            'data-post-id' :data_post_id,
            'data-post-tags' :  tags
        };

        jQuery.post("/wp-admin/admin-ajax.php", data, function (response) {
            $(".activity-tag-list-"+data_post_id).empty();
            $(".activity-tag-list-"+data_post_id).append( response );
            $(".data-post-tags").val('');
            $( "#dialog" ).dialog( "close" );
        });
        return false;
    });

});

