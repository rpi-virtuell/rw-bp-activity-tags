<?php

/**
 * Class RW_BP_Activity_Tags_Core
 *
 * Core functions
 *
 * @package   RW BuddyPress Activity Tags
 * @author    Frank Staude
 * @license   GPL-2.0+
 * @link      https://github.com/rpi-virtuell/rw-bp-activity-tags
 */

class RW_BP_Activity_Tags_Core {


    /**
     *
     * @since    0.0.1
     * @access  public
     * @static
     */
    function init() {}


    // Register Custom Taxonomy
    function register_activity_tag_taxonomy() {
        register_taxonomy( 'activity_tags', array() );
    }

    function add_tag_icon() {
        $nonce = wp_create_nonce( 'tag-activity-nonce' );
        $title = __('tag activity', RW_Sticky_Activity::$textdomain);
        $class = "add-activity-tag ";
        ?>
        <a href="" class="fa fa-tag <?php echo $class; ?>" title="<?php echo $title; ?>" data-post-nonces="<?php echo $nonce; ?>" data-post-id="<?php echo bp_get_activity_id(); ?>"></a>
        <?php
    }

   function show_tags_from_activity() {
    //   var_dump( get_terms( 'activity_tags', $args = '' ) );
    //   var_dump( wp_get_object_terms( bp_get_activity_id(), 'activity_tags', $args = array()) );
       ?>
       <div class='activity-content activity-tag-list'>
       <?php foreach ( wp_get_object_terms( bp_get_activity_id(), 'activity_tags' ) as $term ) { ?>

        <a href="#" class="fa fa-tag activity-tag"><?php echo $term->name; ?></a>

        <?php } ?>
       </div>
    <?php
   }

    function add_tag_activity() {
        $nonce = isset($_REQUEST['data-post-nonces']) ? sanitize_text_field($_REQUEST['nonces']) : 0;
        if (!wp_verify_nonce($nonce, 'tag-activity-nonce')) {
            exit(__('Not permitted', RW_Sticky_Activity::$textdomain));
        }
        $activityID = (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? $_REQUEST['id'] : '';
        if ($activityID != '') {
            //bp_activity_update_meta($activityID, 'rw_sticky_activity', 1);

        }
        echo "hier";

        wp_die();
    }

    function write_dialog() {
        ?>
        <div id="dialog" title="Add Activity Tag">
            <p>This is the default dialog which is useful for displaying information. The <a href="#" class="adas">dialog window</a> can be moved, resized and closed with the 'x' icon.</p>
        </div>
        <?php
    }


    /**
     *
     */
    function register_script() {
        wp_register_style( 'rw_activity_tags_css', plugins_url('/css/style.css', RW_BP_Activity_Tags::$plugin_base_name ), false, RW_BP_Activity_Tags::$plugin_version, 'all');
        wp_register_script( 'activity-tag', plugins_url('/js/rw_bp_activity_tags.js', RW_BP_Activity_Tags::$plugin_base_name ), array( 'jquery', 'jquery-ui-dialog' ) );
        wp_register_style( 'ui-dialog', 'http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css' );
    }

    /**
     *
     */
    function enqueue_style() {
        wp_enqueue_style( 'rw_activity_tags_css' );
        wp_enqueue_style( 'ui-dialog' );
        wp_enqueue_script( 'activity-tag');
    }

}
