<?php
define('AC_VERSION','2.0.0');

if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	wp_die('请升级到4.4以上版本');
}

if(!function_exists('fa_ajax_comment_scripts')) :

    function fa_ajax_comment_scripts(){
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
        wp_enqueue_style( 'ajax-comment', get_template_directory_uri() . '/js/ajax-comment/app.css', array(), AC_VERSION );
        wp_enqueue_script( 'ajax-comment', get_template_directory_uri() . '/js/ajax-comment/app.js', array(), AC_VERSION , true );
        wp_localize_script( 'ajax-comment', 'ajaxcomment', array(
            'ajax_url'   => admin_url('admin-ajax.php'),
            'order' => get_option('comment_order'),
            'formpostion' => 'bottom', //默认为bottom，如果你的表单在顶部则设置为top。
        ) );
    }

endif;

if(!function_exists('fa_ajax_comment_err')) :

    function fa_ajax_comment_err($a) {
        header('HTTP/1.0 500 Internal Server Error');
        header('Content-Type: text/plain;charset=UTF-8');
        echo $a;
        exit;
    }

endif;

if(!function_exists('fa_ajax_comment_callback')) :

    function fa_ajax_comment_callback(){
        $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
        if ( is_wp_error( $comment ) ) {
            $data = $comment->get_error_data();
            if ( ! empty( $data ) ) {
            	fa_ajax_comment_err($comment->get_error_message());
            } else {
                exit;
            }
        }
        $user = wp_get_current_user();
        do_action('set_comment_cookies', $comment, $user);
        $GLOBALS['comment'] = $comment; //根据你的评论结构自行修改，如使用默认主题则无需修改
        ?>
    <li class="comment" id="li-comment-<?php comment_ID(); ?>">
        <div class="media">
            <div class="media-left">
                <?php if (function_exists('get_avatar') && get_option('show_avatars')) {
                    echo get_avatar($comment, 48);
                } ?>
            </div>
            <div class="media-body">
                <?php printf(__('<p class="author_name">%s'), get_comment_author_link());
                echo " " . TM_GetUserAgent($comment->comment_agent) . "</p>"; ?>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em>评论等待审核...</em><br/>
                <?php endif; ?>
                <div class="comment-metadata">
   			<span class="comment-pub-time">
   				<?php echo get_comment_time('Y-m-d H:i'); ?>
   			</span>
                    <span class="comment-btn-reply">
 				<i class="mdui-icon material-icons"
                   style="font-size: 16px">reply</i> <?php comment_reply_link(array_merge($args, array('reply_text' => '回复', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?> <?php edit_comment_link(__('(Edit)'), '&nbsp;&nbsp;', ''); ?>
   			</span>
                </div>
                <div class="tm-comment-text"><?php comment_text(); ?></div>
            </div>
        </div>
        <?php die();
    }

endif;

add_action( 'wp_enqueue_scripts', 'fa_ajax_comment_scripts' );
add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');