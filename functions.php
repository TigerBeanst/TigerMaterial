<?php
//去除管理员条
show_admin_bar(false);

//添加设置页面
define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/');
require_once dirname(__FILE__) . '/inc/options-framework.php';
$optionsfile = locate_template('options.php');
load_template($optionsfile);
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');
include('optionjs.php');

//邮件通知 by Qiqiboy
function comment_mail_notify($comment_id)
{
    $comment = get_comment($comment_id);//根据id获取这条评论相关数据
    $content = $comment->comment_content;
    //对评论内容进行匹配
    $match_count = preg_match_all('/<a href="#comment-([0-9]+)?" rel="nofollow">/si', $content, $matchs);
    if ($match_count > 0) {//如果匹配到了
        foreach ($matchs[1] as $parent_id) {//对每个子匹配都进行邮件发送操作
            SimPaled_send_email($parent_id, $comment);
        }
    } elseif ($comment->comment_parent != '0') {//以防万一，有人故意删了@回复，还可以通过查找父级评论id来确定邮件发送对象
        $parent_id = $comment->comment_parent;
        SimPaled_send_email($parent_id, $comment);
    } else return;
}

add_action('comment_post', 'comment_mail_notify');

function SimPaled_send_email($parent_id, $comment)
{//发送邮件的函数 by Qiqiboy.com
    $admin_email = get_bloginfo('admin_email');//管理员邮箱
    $parent_comment = get_comment($parent_id);//获取被回复人（或叫父级评论）相关信息
    $author_email = $comment->comment_author_email;//评论人邮箱
    $to = trim($parent_comment->comment_author_email);//被回复人邮箱
    $spam_confirmed = $comment->comment_approved;
    if ($spam_confirmed != 'spam' && $to != $admin_email && $to != $author_email) {

        $wp_email = getTigerMaterial('smtp_username');; // e-mail 發出點, no-reply 可改為可用的 e-mail.

        $subject = '你在 [' . get_option("blogname") . '] 的留言有了回应';
        $message = '<body style="margin: 0px!important;"><div id="content"><div style="background:#e0e0e0;color: #666;font-size:12px;"><div class="mdui-shadow-3" style="width: 640px;margin:0 auto;background:#fff;padding:0 0 25px 0;"><div style="margin-bottom: 40px;line-height: 1.8em;"><style>.mdui-shadow-3 { -webkit-box-shadow:0 3px 3px -2px rgba(0,0,0,.2),0 3px 4px 0 rgba(0,0,0,.14),0 1px 8px 0 rgba(0,0,0,.12); box-shadow:0 3px 3px -2px rgba(0,0,0,.2),0 3px 4px 0 rgba(0,0,0,.14),0 1px 8px 0 rgba(0,0,0,.12); } .mdui-card-media { position:relative; } .mdui-card-media img,.mdui-card-media video { display:block; width:100%; } .tm-index-img { width:100%; height:auto; margin:0 auto; } .mdui-card-media-covered { position:absolute; right:0; bottom:0; left:0; color:#fff; background:rgba(0,0,0,.2); } .mdui-card-primary { position:relative; padding:24px 16px 16px 16px; } .mdui-card-media-covered .mdui-card-primary-title { opacity:1; } .mdui-card-primary-title { display:block; font-size:24px; line-height:36px; opacity:.87; } .mdui-card-media-covered .mdui-card-primary-subtitle { opacity:.7; } .mdui-card-primary-subtitle { display:block; font-size:14px; line-height:24px; opacity:.54; }</style><div class="mdui-card-media"><img class="tm-index-img" src="http://127.0.0.1/wp/wp-content/themes/TigerMaterial/images/index.jpg"><div class="mdui-card-media-covered"><div class="mdui-card-primary"><div class="mdui-card-primary-title">测试站点</div><div class="mdui-card-primary-subtitle">又一个WordPress站点</div></div></div></div></div><div style="margin-left: 70px;margin-right: 70px"><p style="font-size:18px;color: #333;">你好 ' . trim(get_comment($parent_id)->comment_author) . '</p><p>你曾在' . get_option('blogname') . '的「' . get_the_title($comment->comment_post_ID) . '」中留下过评论:</p><p style="border: 1px solid #eee;
        padding: 20px;margin: 15px 0;">' . trim(get_comment($parent_id)->comment_content) . '</p><p>' . trim($comment->comment_author) . ' 给您的回复如下:</p><p style="border: 1px solid #eee;padding: 20px;
        margin: 15px 0;">' . trim($comment->comment_content) . '</p><p class="footer" style="border-top: 1px solid #DDDDDD; padding-top:6px; margin-top:15px; color:#838383;">你可以点击此链接<a href="' . htmlspecialchars(get_comment_link($parent_id, array("type" => "all"))) . '">查看完整内容</a>| 欢迎再次来访<a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p><p style="color: #bbb;margin-top: 40px;">请不要回复该邮件，它是由程序自动发出的。</p></div></div></div><style id="ntes_link_color" type="text/css">a,td a{color:#064977}</style></body>';
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail($to, $subject, $message, $headers);
    }
}

//使用smtp发送邮件
add_action('phpmailer_init', 'mail_smtp');
function mail_smtp($phpmailer)
{
    $phpmailer->FromName = getTigerMaterial('smtp_name'); //发件人名称
    $phpmailer->Host = getTigerMaterial('smtp_service'); //修改为你使用的邮箱SMTP服务器
    $phpmailer->Port = getTigerMaterial('smtp_port'); //SMTP端口
    $phpmailer->Username = getTigerMaterial('smtp_username'); //邮箱账户
    $phpmailer->Password = getTigerMaterial('smtp_password'); //邮箱密码
    $phpmailer->From = getTigerMaterial('smtp_fromname'); //邮箱账
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = getTigerMaterial('smtp_secure'); //tls or ssl （port=25时->留空，465时->ssl）
    $phpmailer->IsSMTP();
}

//设置标题
function add_theme_support_title()
{
    add_theme_support('title-tag');

}

add_action('after_setup_theme', 'add_theme_support_title');

//添加缩略图
add_theme_support('post-thumbnails');
set_post_thumbnail_size(984, 400, true);

//文章摘要字数和省略号样式
function tm_excerpt_length()
{
    return 150;
}

function tm_excerpt_more()
{
    return '&hellip;';
}

add_filter('excerpt_length', 'tm_excerpt_length');
add_filter('excerpt_more', 'tm_excerpt_more');

//注册菜单
register_nav_menus(array(
    'sidebar_menu_one' => '抽屉上菜单',
    'sidebar_menu_two' => '抽屉下菜单',
));

//修改菜单class
function tm_menu_classes($classes, $item, $depth)
{
    if (0 == $depth || 1 == $depth) {
        $classes[] = 'mdui-list-item mdui-ripple';
    }
    if (2 == $depth) {
        $classes[] = 'mdui-collapse-item';
    }
    return $classes;
}

add_filter('nav_menu_css_class', 'tm_menu_classes', 1, 3);

//添加友情链接
add_filter("pre_option_link_manager_enabled", "__return_true");

//禁止加载默认jQuery库
function my_enqueue_scripts()
{
    wp_deregister_script('jquery');
}

add_action('wp_enqueue_scripts', 'my_enqueue_scripts', 1);

//使用官方中文源加速 Gravatar 头像
function replace_gravatar($avatar)
{
    $avatar = str_replace(array("//gravatar.com/", "//secure.gravatar.com/", "//www.gravatar.com/", "//0.gravatar.com/", "//1.gravatar.com/", "//2.gravatar.com/", "//cn.gravatar.com/"), "//cn.gravatar.com/", $avatar);
    return $avatar;
}

add_filter('get_avatar_url', 'replace_gravatar');

//屏蔽s.w.org
remove_action('wp_head', 'wp_resource_hints', 2);

//将上传的图片文件用时间命名，来源忘了……
add_filter('wp_handle_upload_prefilter', 'custom_upload_filter');
function custom_upload_filter($file)
{
    $info = pathinfo($file['name']);
    $ext = $info['extension'];
    $filedate = date('YmdHis') . rand(10, 99);//为了避免时间重复，再加一段2位的随机数
    $file['name'] = $filedate . '.' . $ext;
    return $file;
}

//获得翻页URL
function tm_get_nextpage_url($next_button)
{
    $next_dom = get_next_posts_link($next_button);
    $re = '/<a.*?href="(.*?)".*?>navigate_before<\/a>/';
    $str = $next_dom;
    preg_match_all($re, $str, $arr, PREG_SET_ORDER, 0);
    return $arr[0][1];
}

//翻页，来自 WordPress 官方 Twenty Twelve 主题
if (!function_exists('tm_content_nav')) :
    function tm_content_nav($html_id)
    {
        global $wp_query;
        $html_id = esc_attr($html_id);
        if ($wp_query->max_num_pages > 1) : ?>
            <nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
                <h3 class="assistive-text"><?php _e('Post navigation', 'twentytwelve'); ?></h3>
                <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve')); ?></div>
                <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve')); ?></div>
            </nav><!-- #<?php echo $html_id; ?> .navigation -->
        <?php endif;
    }
endif;

//文章归档，来自 https://zww.me
function zww_archives_list()
{
    if (!$output = get_option('zww_db_cache_archives_list')) {
        $output = '<div id="archives"><p><a id="al_expand_collapse" href="#">全部展开/收缩</a> <em>(注: 点击月份可以展开)</em></p>';
        $args = array(
            'post_type' => array('archives', 'post', 'zsay'),
            'posts_per_page' => -1, //全部 posts
            'ignore_sticky_posts' => 1 //忽略 sticky posts

        );
        $the_query = new WP_Query($args);
        $posts_rebuild = array();
        $year = $mon = 0;
        while ($the_query->have_posts()) : $the_query->the_post();
            $post_year = get_the_time('Y');
            $post_mon = get_the_time('m');
            $post_day = get_the_time('d');
            if ($year != $post_year) $year = $post_year;
            if ($mon != $post_mon) $mon = $post_mon;
            $posts_rebuild[$year][$mon][] = '<li>' . get_the_time('d日: ') . '<a href="' . get_permalink() . '">' . get_the_title() . '</a> <em>(' . get_comments_number('0', '1', '%') . ')</em></li>';
        endwhile;
        wp_reset_postdata();

        foreach ($posts_rebuild as $key_y => $y) {
            $y_i = 0;
            $y_output = '';
            foreach ($y as $key_m => $m) {
                $posts = '';
                $i = 0;
                foreach ($m as $p) {
                    ++$i;
                    ++$y_i;
                    $posts .= $p;
                }
                $y_output .= '<li><span class="al_mon">' . $key_m . ' 月 <em>( ' . $i . ' 篇文章 )</em></span><ul class="al_post_list">'; //输出月份
                $y_output .= $posts; //输出 posts
                $y_output .= '</ul></li>';
            }
            $output .= '<h3 class="al_year">' . $key_y . ' 年 <em>( ' . $y_i . ' 篇文章 )</em></h3><ul class="al_mon_list">'; //输出年份
            $output .= $y_output;
            $output .= '</ul>';
        }

        $output .= '</div>';
        update_option('zww_db_cache_archives_list', $output);
    }
    echo $output;
}

function clear_db_cache_archives_list()
{
    update_option('zww_db_cache_archives_list', ''); // 清空 zww_archives_list
}

add_action('save_post', 'clear_db_cache_archives_list'); // 新发表文章/修改文章时


//文章目录TOC
function article_toc($content)
{
    /**
     * 名称: getTOC
     * 作者: HjtHjtHjt
     * 博客：https://jakting.com/
     * 修改时间：2019年10月15日
     */
    $reg_title = '/<h(.*?)>(.*?)<\/h.*?>/';
    $content_toc = "<ul class=\"toc_list\">";
    $title_1 = 0;
    $title_2 = 0;
    $title_3 = 0;
    preg_match_all($reg_title, $content, $matches_reg, PREG_SET_ORDER, 0);
    $count = count($matches_reg);
    //判断是否存在目录
    if ($count == 0) {
        //没有
        $flag = false;
        $return = array($content, null, $flag);
    } else {
        //有
        function str_replace_limit($search, $replace, $subject, $limit = 1)
        {
            if (is_array($search)) {
                foreach ($search as $k => $v) {
                    $search[$k] = '`' . preg_quote($search[$k], '`') . '`';
                }
            } else {
                $search = '`' . preg_quote($search, '`') . '`';
            }
            return preg_replace($search, $replace, $subject, $limit);
        }

        for ($ii = 0; $ii < $count; $ii++) {
            $title_number = $matches_reg[$ii][1]; //h2，h3，h4的数字
            $title_word = $matches_reg[$ii][2]; //h2，h3，h4的标题
            //echo "第 $ii 个的title_number为：$title_number ，title_word为 $title_word <br>";
            if ($title_number == "2") {
                $title_1++;
                $content = str_replace_limit("<h2>$title_word</h2>", "<h2 id=\"title-$title_1\">$title_word</h2>", $content);
                if ($title_3 != 0) {
                    $content_toc .= "</ul></li>";
                    $title_3 = 0;
                }
                if ($title_2 != 0) {
                    $content_toc .= "</ul></li>";
                    $title_2 = 0;
                }
                $content_toc .= "<li><a href=\"#title-$title_1\">$title_1 $title_word</a>";
            } else if ($title_number == "3") {
                if ($title_2 == 0) $content_toc .= "<ul>";
                $title_2++;
                $content = str_replace_limit("<h3>$title_word</h3>", "<h3 id=\"title-$title_1-$title_2\">$title_word</h3>", $content);
                if ($title_3 != 0) {
                    $content_toc .= "</ul></li>";
                    $title_3 = 0;
                }
                $content_toc .= "<li><a href=\"#title-$title_1-$title_2\">$title_1.$title_2 $title_word</a>";

            } else if ($title_number == "4") {
                if ($title_3 == 0) $content_toc .= "<ul>";
                $title_3++;
                $content = str_replace_limit("<h4>$title_word</h4>", "<h4 id=\"title-$title_1-$title_2-$title_3\">$title_word</h4>", $content);
                $content_toc .= "<li><a href=\"#title-$title_1-$title_2-$title_3\">$title_1.$title_2.$title_3 $title_word</a></li>";
            }
        }
        if ($title_3 != 0) $content_toc .= "</ul></li>";
        if ($title_2 != 0) $content_toc .= "</ul></li>";
        $content_toc .= "</ul>";
        $flag = true;
        //修改文章内部链接完成
        $return = array($content, $content_toc, $flag);
    }
    return $return;
}

//UA显示
function TM_GetUserAgent($ua)
{
    /*
     * 由于未来 Chrome 将不再在 UA 中输出有关操作系统的字段以用于判断设备类型（PC还是手机），因此自此开始评论不再显示系统，只显示浏览器
     * 详见：https://groups.google.com/a/chromium.org/forum/#!msg/blink-dev/-2JIRNMWJ7s/yHe4tQNLCgAJ
     */

    /* 浏览器 */
    $br = "<i class='mdui-icon material-icons' style='font-size: 20px'> public</i> UNKNOWN";;
    $br_v = null;

    //Chrome
    $re = "/Chrome\/(.*?) S/i";
    if (preg_match($re, $ua, $os_matches, PREG_OFFSET_CAPTURE, 0)) {
        $br = "<i class='mdui-icon material-icons' style='font-size: 20px'>public</i> Chrome " . $os_matches[1][0];
    }

    //Safari
    $re = "/Version\/.*?Safari\/(.*?)/i";
    if (preg_match($re, $ua, $os_matches, PREG_OFFSET_CAPTURE, 0)) {
        $br = "<i class='mdui-icon material-icons' style='font-size: 20px'>public</i> Safari";
    }

    //Firefox
    $re = "/Firefox\/(.*?)/i";
    if (preg_match($re, $ua, $os_matches, PREG_OFFSET_CAPTURE, 0)) {
        $br = "<i class='mdui-icon material-icons' style='font-size: 20px'>public</i> Firefox " . $os_matches[1][0];
    }
    //Internet Explorer
    $re = "/MSIE (.*?);/i";
    if (preg_match($re, $ua, $os_matches, PREG_OFFSET_CAPTURE, 0)) {
        $br = "<i class='mdui-icon material-icons' style='font-size: 20px'>public</i> Internet Explorer " . $os_matches[1][0];
    }
    return $br;
}

//自定义评论列表模板，来自 https://dedewp.com/17366.html
function zmblog_comment($comment, $args, $depth)
{
$GLOBALS['comment'] = $comment; ?>
<li class="comment" id="li-comment-<?php comment_ID(); ?>">
    <div class="media">
        <div class="media-left">
            <?php if (function_exists('get_avatar') && get_option('show_avatars')) {
                echo get_avatar($comment, 48);
            } ?>
        </div>
        <div class="media-body">
            <?php printf(__('<p class="author_name">%s</p>'), get_comment_author_link()); ?>
            <?php echo TM_GetUserAgent($comment->comment_agent); ?>
            <?php if ($comment->comment_approved == '0') : ?>
                <em>评论等待审核...</em><br/>
            <?php endif; ?>
            <div class="tm-comment-text"><?php comment_text(); ?></div>
        </div>
    </div>
    <div class="comment-metadata">
   			<span class="comment-pub-time">
   				<?php echo get_comment_time('Y-m-d H:i'); ?>
   			</span>
        <span class="comment-btn-reply">
 				<i class="mdui-icon material-icons"
                   style="font-size: 16px">reply</i> <?php comment_reply_link(array_merge($args, array('reply_text' => '回复', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?> <?php edit_comment_link(__('(Edit)'), '&nbsp;&nbsp;', ''); ?>
   			</span>
    </div>
    <?php
    }
    ?>
