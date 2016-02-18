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
       <div class='activity-content activity-tag-list activity-tag-list-<?php echo bp_get_activity_id();?>'>
       <?php foreach ( wp_get_object_terms( bp_get_activity_id(), 'activity_tags' ) as $term ) { ?>

        <a href="#" class="fa fa-tag activity-tag"><?php echo $term->name; ?></a>

        <?php } ?>
       </div>
    <?php
   }

    function add_tag_activity() {
        $nonce = isset($_REQUEST['data-post-nonces']) ? sanitize_text_field($_REQUEST['data-post-nonces']) : 0;
        if (! wp_verify_nonce( $nonce, 'tag-activity-nonce' ) ) {
            exit( __( 'Not permitted', RW_BP_Activity_Tags::$textdomain ) );
        }
        $activityID = ( isset( $_REQUEST['data-post-id' ] ) && is_numeric( $_REQUEST[ 'data-post-id' ] ) ) ? $_REQUEST[ 'data-post-id' ] : '';
        $tags =  isset( $_REQUEST[ 'data-post-tags' ] ) ? sanitize_text_field($_REQUEST[ 'data-post-tags' ] ) : '';
        if ($activityID != '' &&  $tags != '') {
            $tagarray = explode( ',', $tags );
            foreach ( $tagarray as $tag ) {
                if (! term_exists( sanitize_title( $tag), 'activity_tags' ) ) {
                    wp_insert_term( sanitize_title( $tag), 'activity_tags'  );
                }
                $termID = term_exists( sanitize_title( $tag), 'activity_tags' );
                $term = get_term_by('id', $termID['term_id'], 'activity_tags');
                wp_set_object_terms( $activityID, $term->term_id, 'activity_tags', true );
            }
        }
        ?>
            <?php foreach ( wp_get_object_terms( $activityID, 'activity_tags' ) as $term ) { ?>
                <a href="#" class="fa fa-tag activity-tag"><?php echo $term->name; ?></a>
            <?php } ?>
        <?php
        wp_die();
    }

    function write_dialog() {
        ?>
        <div id="dialog" title="Add Activity Tag">
            <?php _e( 'Enter tags for the activity', RW_BP_Activity_Tags::$textdomain ); ?><br>
                <form>
            <input type="text" name="tags" class="data-post-tags"><div style="float: right;" class="adas fa">ok</div> </form>
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
