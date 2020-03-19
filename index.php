<?php
get_header();
?>
<body class="mdui-color-grey-300">
<?php wp_body_open(); ?>
<div class="tm-index mdui-center mdui-clearfix">
    <div class="tm-header">
        <div class="mdui-col-md-8 mdui-col-sm-12">
            <div class="mdui-card mdui-hoverable" id="index_left_div">
                <div class="mdui-card-media">
                    <img class="tm-index-img" src="<?php bloginfo('template_url'); ?>/images/index.jpg"/>
                    <div class="mdui-card-media-covered">
                        <div class="mdui-card-primary">
                            <div class="mdui-card-primary-title"><?php bloginfo('author'); ?>
                            </div>
                            <div class="mdui-card-primary-subtitle"><?php bloginfo('description'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mdui-col-md-4 mdui-hidden-sm-down">
            <div class="mdui-card mdui-hoverable tm-headar-right mdui-valign">
                <div class="mdui-card-media mdui-center">
                    <img class="tm-index-img-side" src="<?php bloginfo('template_url'); ?>/images/index-side.png"/>
                </div>
            </div>
        </div>
    </div>
    <div class="container tm-index-archives mdui-col-xl-12">
        <?php if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>
            <div class="item mdui-card mdui-hoverable tm-index-single">
                <div class="mdui-card-media tm-index-single-img">
                    <img src='<?php $img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "Full");
                    if ($img_src) {
                        echo $img_src[0];
                    } else {
                        $rann = rand(1, 19);
                        echo get_bloginfo("template_url") . "/images/random/material-" . $rann . ".png";
                    }; ?>'/>
                    <div class="mdui-card-media-covered mdui-card-media-covered-gradient">
                        <div class="mdui-card-primary mdui-m-l-1">
                            <div class="mdui-card-primary-title"><a href="<?php the_permalink(); ?>"
                                                                    class="mdui-text-color-white tm-index-single-title"><?php if(is_sticky()){echo "<i class=\"mdui-icon material-icons\">turned_in</i>";} the_title(); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mdui-card-actions mdui-color-white">
                    <div class="mdui-typo mdui-typo-subheading mdui-m-a-2 mdui-text-color-grey-600">
                        <p><?php the_excerpt(); ?></p>
                    </div>
                    <div class="mdui-typo">
                        <hr/>
                    </div>
                    <div class="mdui-typo-subheading mdui-m-a-1 mdui-text-color-grey-600">
                        <div class="mdui-float-left">
                            <div class="mdui-chip mdui-m-r-1">
                                    <span class="mdui-chip-icon"><i
                                                class="mdui-icon material-icons tm-chip-icon">access_time</i></span>
                                <span class="mdui-chip-title"><?php the_time('M d, Y') ?></span>
                            </div>
                            <div class="mdui-chip tm-chip-mobile"
                                 onclick="window.location.href='<?php the_permalink(); ?>#comments'">
                                    <span class="mdui-chip-icon"><i
                                                class="mdui-icon material-icons tm-chip-icon">chat_bubble_outline</i></span>
                                <span class="mdui-chip-title"><?php comments_number('没有评论', '1条评论', '%条评论'); ?></span>
                            </div>
                        </div>
                        <div class="mdui-float-right">
                            <button class="mdui-btn mdui-ripple"
                                    onclick="window.location.href='<?php the_permalink(); ?>'">阅读全文
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        <?php endif; ?>
        <?php tm_content_nav('nav-below'); ?>
    </div>
</div>
</body>
<?php
get_footer();
?>
<script src="<?php bloginfo('template_url'); ?>/js/infinite-ajax-scroll.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/style-before.js"></script>
