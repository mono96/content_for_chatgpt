<?php
/**
 * Plugin Name: Content for ChatGPT
 * Plugin URI: 
 * Description: You can copy the text of a question for a proposed title and description to Chat-GPD with one click from the article editing screen. API Key is not required.
 * Version: 1.0
 * Author: Nobuhito Ohigashi
  * Author URI: https://mono96.jp
  * Text Domain: CFCG_content_for_ChatGPT
  * Domain Path: /languages/
  * License: GPL2
 */

// Add a custom meta box to the post editor screen
function ATB_custom_meta_box() {
    add_meta_box(
        'ATB_custom_post_content_meta_box', // Unique ID of the meta box
        'Content for ChatGPT', // Title of the meta box
        'ATB_custom_meta_box_callback', // Callback function to render the meta box content
        'post', // Post type to display the meta box
        'normal', // Context of the meta box (normal, side, advanced)
        'high' // Priority of the meta box (default, high, low)
    );
}
add_action( 'add_meta_boxes', 'ATB_custom_meta_box' );

// Callback function to render the meta box content
function ATB_custom_meta_box_callback( $post ) {
    // Retrieve the post ID
    $post_id = $post->ID;

    // Get the post content
    $post_content = get_post_field( 'post_content', $post_id );

    // Unslash the post content to remove any slashes added by WordPress
    $post_content = wp_unslash( $post_content );

    // Remove HTML tags and convert entities to plain text
    $post_content_text = wp_strip_all_tags( $post_content, true );

    // Add a "Copy" button and wrap the post content text in a <div> element with a unique ID
    echo '<div class="ATB_btn"><button id="ATB_copy_button" type="button">Copy</button></div>';
    echo '<input type="radio" id="ATB_no_radio" name="ATB_summary_radio" value="summary1" checked="checked">';
    echo '<label for="ATB_no_radio">何もしない</label>';
    echo '<input type="radio" id="ATB_title_radio" name="ATB_summary_radio" value="summary2">';
    echo '<label for="ATB_title_radio">タイトル</label>';
    echo '<input type="radio" id="ATB_summary_radio" name="ATB_summary_radio" value="summary3">';
    echo '<label for="ATB_summary_radio">要約</label>';

    echo '<div id="ATB_post_content_text">' . esc_html( $post_content_text ) . '</div>';
}

function ATB_custom_meta_box_scripts() {
    wp_enqueue_style( 'ATB_custom-meta-box-styles', plugin_dir_url( __FILE__ ) . 'custom-meta-box.css' );
    wp_enqueue_script( 'ATB_custom-meta-box-scripts', plugin_dir_url( __FILE__ ) . 'ja-custom-meta-box.js', array( 'jquery' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'ATB_custom_meta_box_scripts' );



