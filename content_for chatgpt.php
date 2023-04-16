<?php
/**
 * Plugin Name: Content for ChatGPT
 * Plugin URI: https://github.com/mono96/content_for_chatgpt
 * Description: You can copy the text of a question for a proposed title and description to Chat-GPD with one click from the article editing screen. API Key is not required.
 * Version: 1.0.1
 * Author: Nobuhito Ohigashi
  * Author URI: https://mono96.jp
  * Text Domain: CFCG_content_for_ChatGPT
  * Domain Path: /languages/
  * License: GPL2
 */

// ATB_article_text_box_plugin チェック
// アクションフックを追加
register_activation_hook(__FILE__, 'CFCG_your_plugin_activation');

function CFCG_your_plugin_activation() {
    // プラグインが有効化されたときに、トランジェントを設定
    set_transient('CFCG_your_plugin_welcome_message', true, 5);
}

// 管理画面にエラーメッセージを表示
add_action('admin_notices', 'CFCG_your_plugin_display_welcome_message');

function CFCG_your_plugin_display_welcome_message() {
    // トランジェントを取得
    if (get_transient('CFCG_your_plugin_welcome_message')) {
        // メッセージを表示
        
    // ATB_article_text_boxプラグインのパス
    $atb_plugin_path = 'ATB_article_text_box.php/ATB_article_text_box.php';
    if (is_plugin_active($atb_plugin_path) || file_exists(WP_PLUGIN_DIR . '/' . $atb_plugin_path)) {
        
        // プラグインを有効化しました を消す
        unset($_GET['activate']);
        // 管理画面にメッセージを表示

            ?>
            <div class="notice notice-error">
                <p><?php _e('<strong>エラー：</strong> ATB_article_text_boxプラグインがインストールされています。このプラグインと競合する可能性があるため、ATB_article_text_boxプラグインを無効化および削除してから、再度このプラグインを有効化してください。削除が完了しないと、プラグインを有効化できません。', 'your-plugin-textdomain'); ?></p>
            </div>
            <?php
            // 現在のプラグインを無効化
            deactivate_plugins(plugin_basename(__FILE__));
        }
        // トランジェントを削除
        delete_transient('CFCG_your_plugin_welcome_message');
    }
}

// Add a custom meta box to the post editor screen
function CFCG_custom_meta_box() {
    add_meta_box(
        'CFCG_custom_post_content_meta_box', // Unique ID of the meta box
        'Content for ChatGPT', // Title of the meta box
        'CFCG_custom_meta_box_callback', // Callback function to render the meta box content
        'post', // Post type to display the meta box
        'normal', // Context of the meta box (normal, side, advanced)
        'high' // Priority of the meta box (default, high, low)
    );
}
add_action( 'add_meta_boxes', 'CFCG_custom_meta_box' );

// Callback function to render the meta box content
function CFCG_custom_meta_box_callback( $post ) {
    // Retrieve the post ID
    $post_id = $post->ID;

    // Get the post content
    $post_content = get_post_field( 'post_content', $post_id );

    // Unslash the post content to remove any slashes added by WordPress
    $post_content = wp_unslash( $post_content );

    // Remove HTML tags and convert entities to plain text
    $post_content_text = wp_strip_all_tags( $post_content, true );

    // Add a "Copy" button and wrap the post content text in a <div> element with a unique ID
    echo '<div class="CFCG_btn"><button id="CFCG_copy_button" type="button">Copy</button></div>';
    echo '<input type="radio" id="CFCG_no_radio" name="CFCG_summary_radio" value="summary1" checked="checked">';
    echo '<label for="CFCG_no_radio">何もしない</label>';
    echo '<input type="radio" id="CFCG_title_radio" name="CFCG_summary_radio" value="summary2">';
    echo '<label for="CFCG_title_radio">タイトル</label>';
    echo '<input type="radio" id="CFCG_summary_radio" name="CFCG_summary_radio" value="summary3">';
    echo '<label for="CFCG_summary_radio">要約</label>';

    echo '<div id="CFCG_post_content_text">' . esc_html( $post_content_text ) . '</div>';
    echo '<div id="CFCG_after_post_content_text">' . '<p>下書き保存が必要です。文章が、変更されない&表示されないときは、ブラウザーで再読み込みしてください。' . '</div>';
    
    //echo '<p>'.  plugins_url() . '/ATB_article_text_box.php/ATB_article_text_box.php</p>';
}

function CFCG_custom_meta_box_scripts() {
    wp_enqueue_style( 'CFCG_custom-meta-box-styles', plugin_dir_url( __FILE__ ) . 'custom-meta-box.css' ,'1.0.1');
    wp_enqueue_script( 'CFCG_custom-meta-box-scripts', plugin_dir_url( __FILE__ ) . 'ja-custom-meta-box.js', array( 'jquery' ),  '1.0.2', true );
}
add_action( 'admin_enqueue_scripts', 'CFCG_custom_meta_box_scripts' );
