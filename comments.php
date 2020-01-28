<?php
//自定义评论列表模板 by www.zhuimeikeji.com
if (post_password_required())
    return;
?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/comments.css">
<div id="comments" class="responsesWrapper commentshow mdui-typo-subheading mdui-m-a-1 mdui-text-color-grey-600">
    <meta content="UserComments:<?php echo number_format_i18n(get_comments_number()); ?>" itemprop="interactionCount">
    <h3 class="comments-title">共有 <span
                class="commentCount"><?php echo number_format_i18n(get_comments_number()); ?></span> 条评论</h3>
    <div class="comments-loading">Loading...</div>
    <ol class="commentlist">
        <?php
        wp_list_comments(array(
            'style' => 'ol',
            'short_ping' => true,
            'avatar_size' => 48,
            'type' => 'comment',
            'callback' => 'zmblog_comment',
        ));
        ?>
    </ol>
    <nav class="comment-navigation u-textAlignCenter" data-fuck="<?php the_ID(); ?>" id="comment-nav">
        <?php paginate_comments_links(array('prev_next' => true)); ?>
    </nav>
    <?php if (comments_open()) : ?>
        <div class="mdui-typo-headline">发表评论</div>
        <div id="respond" class="respond" role="form">
            <h2 id="reply-title" class="comments-title"><?php comment_form_title('', '回复给 %s'); ?> <small>
                    <?php cancel_comment_reply_link(); ?>
                </small></h2>
            <?php if (get_option('comment_registration') && !$user_ID) : ?>
                <p>你必须
                    <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">登陆</a>
                    后才能做评价.</p>
            <?php else : ?>
                <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post"
                      class="commentform" id="commentform">
                    <?php if ($user_ID) : ?>
                        <p class="warning-text" style="margin-bottom:10px">以<a
                                    href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>身份登录&nbsp;|&nbsp;<a
                                    class="link-logout" href="<?php echo wp_logout_url(get_permalink()); ?>">注销
                                &raquo;</a></p>
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <label class="mdui-textfield-label">评论内容</label>
                            <textarea class="mdui-textfield-input" id="comment" rows="4"
                                      onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"
                                      tabindex="1" name="comment"></textarea>
                        </div>
                    <?php else : ?>
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <label class="mdui-textfield-label">评论内容</label>
                            <textarea class="mdui-textfield-input" id="comment" rows="4"
                                      onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"
                                      tabindex="1" name="comment"></textarea>
                        </div>
                        <div class="mdui-row">
                            <div class="mdui-col-xs-4 mdui-textfield mdui-textfield-floating-label">
                                <label class="mdui-textfield-label">昵称</label>
                                <input class="mdui-textfield-input" id="author" type="text"
                                       value="<?php echo $comment_author; ?>" name="author" required/>
                                <div class="mdui-textfield-error">昵称不能为空</div>
                            </div>
                            <div class="mdui-col-xs-4 mdui-textfield mdui-textfield-floating-label">
                                <label class="mdui-textfield-label">邮箱</label>
                                <input class="mdui-textfield-input" id="email" type="text"
                                       value="<?php echo $comment_author_email; ?>" name="email" required/>
                                <div class="mdui-textfield-error">邮箱不能为空</div>
                            </div>
                            <div class="mdui-col-xs-4 mdui-textfield mdui-textfield-floating-label">
                                <label class="mdui-textfield-label">网站</label>
                                <input class="mdui-textfield-input" id="url" type="text"
                                       value="<?php echo $comment_author_url; ?>" name="url"/>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="btn-group commentBtn" role="group">
                        <button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-grey-700" name="submit"
                                id="submit">发表评论
                        </button>
                        <?php comment_id_fields(); ?>
                </form>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>