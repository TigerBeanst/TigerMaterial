<!DOCTYPE html>
<html <?php language_attributes(); ?> class="mdui-theme-accent-indigo">
<html prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="profile" href="https://gmpg.org/xfn/11"/>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="theme-color" content="<?php echo getTigerMaterial('tm_status_color'); ?>">
    <meta name="keywords" content="<?php echo getTigerMaterial('seo_author'); ?>">
    <meta name="author" content="<?php echo getTigerMaterial('seo_author'); ?>">
    <?php if (is_single() || is_page()) { ?>
        <meta property="og:title" name="title" content="<?php the_title(); ?>"/>
        <meta property="og:description" content="<?php the_excerpt(); ?>"/>
        <meta property="og:site_name" content="<?php bloginfo("name"); ?>"/>
    <?php } else { ?>
        <meta property="og:title" content="<?php bloginfo("name"); ?>"/>
        <meta property="og:description" content="<?php bloginfo('description'); ?>"/>
    <?php } ?>
    <meta name="description" itemprop="description" content="<?php echo getTigerMaterial('seo_description'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/mdui.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
    <?php if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    } ?>
    <?php wp_head(); ?>
</head>

<?php /* 顶部工具栏 */ ?>
<div id="tm-toolbar" class="mdui-toolbar mdui-appbar-fixed mdui-appbar-scroll-hide">
    <a href="javascript:;" class="mdui-btn mdui-btn-icon" mdui-drawer="{target:'#left-drawer',overlay:true,swipe:true}"><i
                class="mdui-icon material-icons">menu</i></a>
    <?php if (is_single() || is_page()) { ?>
        <a href="<?php bloginfo('url'); ?>">
            <button class="mdui-textfield-icon mdui-btn mdui-btn-icon" mdui-tooltip="{content: '回到首页'}"><i
                        class="mdui-icon material-icons">home</i>
            </button>
        </a>
    <?php } ?>
    <div class="mdui-toolbar-spacer"></div>
    <div class="mdui-textfield mdui-textfield-expandable mdui-float-right">
        <a>
            <button class="mdui-textfield-icon mdui-btn mdui-btn-icon" mdui-tooltip="{content: '搜索'}"><i
                        class="mdui-icon material-icons">search</i>
            </button>
        </a>
        <form action="<?php bloginfo("url"); ?>">
            <input type="text" id="search" class="mdui-textfield-input" name="s"
                   results="0" placeholder="搜索">
        </form>

        <button class="mdui-textfield-close mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">close</i>
        </button>
    </div>
    <a href="<?php bloginfo('atom_url'); ?>" target="_blank">
        <button class="mdui-textfield-icon mdui-btn mdui-btn-icon" mdui-tooltip="{content: 'RSS'}"><i
                    class="mdui-icon material-icons">rss_feed</i>
        </button>
    </a>
    <?php $user = get_user_by('id', 1); ?>
    <div class="mdui-chip mdui-m-r-2">
        <div style="margin-top: -13px">
            <img class="mdui-chip-icon" src="<?php echo get_avatar_url(1); ?>"/>
            <span id="tm-chip-title" class="mdui-chip-title"><?php echo $user->user_nicename; ?></span>
        </div>
    </div>
</div>

<?php /* 抽屉 */ ?>
<div class="mdui-drawer mdui-color-white mdui-drawer-close" id="left-drawer">
    <div class="tm-sidebar">
        <div class="mdui-card-media">
            <img src="<?php bloginfo('template_url'); ?>/images/sidebar.jpg" class="tm-sidebar-img">
            <div class="mdui-card-media-covered">
                <div class="mdui-card-header">
                    <div class="mdui-card-header-avatar"
                         style="background-image: url('<?php echo get_avatar_url(1); ?>');background-size: contain"></div>
                    <div class="mdui-card-header-title"><?php /* 昵称 */
                        echo $user->user_nicename; ?></div>
                    <div class="mdui-card-header-subtitle"><?php /* 介绍（仅10个字） */
                        echo $user->user_description; ?></div>
                </div>
            </div>
        </div>
        <?php if (has_nav_menu('sidebar_menu_one')) { ?>
            <ul class="mdui-list" mdui-collapse="{accordion: true}">
                <?php
                //抽屉二级菜单，代码来自MDx主题，感谢！
                wp_nav_menu(array('theme_location' => 'sidebar_menu_one', 'menu' => 'menu-nav', 'depth' => 2, 'container' => false, 'menu_class' => 'mdui-list', 'menu_id' => 'menu-nav'));
                ?>
            </ul>
        <?php } ?>
        <?php if (has_nav_menu('sidebar_menu_two')) { ?>
            <div class="mdui-typo">
                <hr>
            </div>
            <ul class="mdui-list" mdui-collapse="{accordion: true}">
                <?php
                //抽屉二级菜单，代码来自MDx主题，感谢！
                wp_nav_menu(array('theme_location' => 'sidebar_menu_two', 'menu' => 'menu-nav', 'depth' => 2, 'container' => false, 'menu_class' => 'mdui-list', 'menu_id' => 'menu-nav'));
                ?>
            </ul>
        <?php } ?>

    </div>
</div>

<?php /* 占位盒子 */ ?>
<div class="tm-top mdui-hidden-sm-down"></div>
<div class="tm-mobile mdui-hidden-md-up"></div>

