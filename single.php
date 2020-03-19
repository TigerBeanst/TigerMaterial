<?php
get_header();
?>
<body class="mdui-color-grey-300">
<?php wp_body_open(); ?>
<div class="tm-index mdui-center mdui-clearfix">
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
                            <div class="mdui-card-primary-title"><span
                                        class="mdui-text-color-white tm-index-single-title"><?php the_title(); ?><?php edit_post_link(' [<i class="mdui-icon material-icons mdui-typo-subheading">edit</i>编辑文章]', '<span>', '</span>',0,'mdui-typo-subheading tm-index-single-title mdui-text-color-white'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mdui-card-actions mdui-color-white">
                    <div class="mdui-typo mdui-typo-subheading mdui-m-a-4 mdui-text-color-grey-600">
                        <span class="byline-name" style="display: none"><?php the_author(); ?></span>
                        <p><?php $content = article_toc(apply_filters( 'the_content', get_the_content()));
                            echo $content[0]?></p>
                        <?php if (!$content[2]) {//没有目录?>
                            <button id="toTop"
                                    class="mdui-fab mdui-fab-fixed mdui-ripple mdui-color-grey-700"
                                    mdui-fab="{trigger: 'click'}"><i
                                        class="mdui-icon material-icons">expand_less</i>
                            </button>
                        <?php } else { ?>
                            <div class="mdui-fab-wrapper" mdui-fab="{trigger: 'click'}">
                                <button class="mdui-fab mdui-ripple mdui-color-grey-700">
                                    <i class="mdui-icon material-icons">bubble_chart</i>
                                    <i class="mdui-icon mdui-fab-opened material-icons">bubble_chart</i>
                                </button>
                                <div class="mdui-fab-dial">
                                    <button id="toTop" class="mdui-fab mdui-fab-mini mdui-ripple mdui-color-grey-800"
                                            mdui-fab="{trigger: 'click'}">
                                        <i class="mdui-icon material-icons">expand_less</i></button>
                                    <button class="mdui-fab mdui-fab-mini mdui-ripple mdui-color-grey-700"
                                            mdui-menu="{target: '#toc',position:'top',align:'right',covered:false}"><i
                                                class="mdui-icon material-icons">format_list_numbered</i>
                                    </button>
                                    <div class="mdui-menu tm-toc" id="toc">
                                        <p><b>目录</b></p>
                                        <?php echo $content[1]; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <blockquote class="tm-single-end-blockquote">
                            <p style="word-break:break-all;"><b>本文采用 <a href="<?php echo getTigerMaterial('tm_cc_url', 'https://creativecommons.org/licenses/by-nc-sa/4.0/deed.zh'); ?>"
                                                                        target="_blank" class="footer-develop-a"><?php echo getTigerMaterial('tm_cc_name', 'CC BY-NC-SA 4.0'); ?></a>
                                    协议进行许可，在您遵循此协议的情况下，可以自由共享与演绎本文章。</b></p>
                            <p style="word-break:break-all;"><b>本文链接：</b><a
                                        href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></p>
                        </blockquote>
                    </div>
                    <div class="mdui-typo">
                        <hr/>
                    </div>
                    <div class="mdui-typo-subheading mdui-m-a-1 mdui-text-color-grey-600" id="tm-single-footer">
                        <div class="mdui-float-left">
                            <div class="mdui-chip mdui-m-r-1">
                                    <span class="mdui-chip-icon"><i
                                                class="mdui-icon material-icons tm-chip-icon">access_time</i></span>
                                <span class="mdui-chip-title"><span
                                            class="tm-single-time-none">发布时间：</span><?php the_time('M d, Y') ?></span>
                            </div>
                            <div class="mdui-chip mdui-m-r-1">
                                    <span class="mdui-chip-icon"><i
                                                class="mdui-icon material-icons tm-chip-icon">update</i></span>
                                <span class="mdui-chip-title"><span
                                            class="tm-single-time-none">更新时间：</span><span
                                            class="dateline"><?php the_modified_time('M d, Y') ?></span></span>
                            </div>
                        </div>
                        <div class="mdui-float-right">
                            <button class="mdui-textfield-icon mdui-btn mdui-btn-icon"
                                    mdui-menu="{target: '#tm-single-share',position:'top', align:'right'}"><i
                                        class="mdui-icon material-icons">share</i>
                            </button>
                            <ul class="mdui-menu" id="tm-single-share">
                                <li class="mdui-menu-item">
                                    <a onclick="javascript:window.open('http://service.weibo.com/share/share.php?&title=<?php the_title(); ?>&url=<?php the_permalink(); ?>&pic=&searchPic=false&style=simple','_blank')"
                                       class="mdui-ripple">分享到微博</a>
                                </li>
                                <li class="mdui-menu-item">
                                    <a onclick="javascript:window.open('https://twitter.com/share?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>','_blank')"
                                       class="mdui-ripple">分享到 Twitter</a>
                                </li>
                                <li class="mdui-menu-item">
                                    <a onclick="javascript:window.open('https://www.facebook.com/sharer.php?title=<?php the_title(); ?>&u=<?php the_permalink(); ?>','_blank')"
                                       class="mdui-ripple">分享到 Facebook</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php comments_template(); ?>
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
