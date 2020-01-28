//抽屉二级菜单，代码来自MDx主题，感谢！
$(function () {
    var mdx_haveChild = 0;
    var mdx_is_c = 0;
    $('#menu-nav > li').each(function () {
        if ($(this).hasClass('menu-item-has-children')) {
            $(this).addClass('mdui-collapse-item');
            $(this).removeClass('mdui-list-item');
            $(this).html('<div class="mdui-collapse-item-header mdui-list-item mdui-ripple"><div class="mdui-list-item-content"><a class="mdx-sub-menu-a" href="' + $(this).children("a").attr('href') + '">' + $(this).children("a").html() + '</a></div><i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i></div><ul class="mdui-collapse-item-body mdui-list mdui-list-dense">' + $(this).children("ul").html() + '</ul>');
            mdx_haveChild = 1;
            $(this).children("ul").children("li").each(function () {
                if ($(this).hasClass('current-menu-item')) {
                    mdx_is_c = 1;
                }
            })
            if (mdx_is_c) {
                $(this).removeClass('current-menu-item');
                $(this).removeClass('current_page_item');
                $(this).addClass('mdui-collapse-item-open');
            }
            mdx_is_c = 0;
        }
        if (mdx_haveChild) {
            $('#menu-nav').addClass('mdui-collapse');
            $('#menu-nav').attr('mdui-collapse', '');
        }
    })
    new mdui.Collapse("#menu-nav");
});

//回到顶部
var toTop = new ScrollToTop("#toTop", {
    showWhen: 100,
    speed: 50,
    fadeSpeed: 12
});

//目录跳转
$('a').click(function (event) {
    // 此处正则用于转换带页面URL的锚点，如 http://abc.html#div,具体正则格式据实际情况而定
    var targetId = $(this).attr('href');
    $("html,body").animate({scrollTop: $(targetId).offset().top}, 500);
});

//Ajax 评论翻页，来自 https://www.mzihen.com/wordpress-ajax-comments-pages/
$(document).ready(function ($) {
    $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');//commentnav ajax
    $(document).on('click', '.comment-navigation a', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            beforeSend: function () {
                $('.comment-navigation').remove();
                $('.commentlist').remove();
                $('.comments-loading').slideDown();
            },
            dataType: "html",
            success: function (out) {
                result = $(out).find('.commentlist');
                nextlink = $(out).find('.comment-navigation');
                $('.comments-loading').slideUp(550);
                $('.comments-loading').after(result.fadeIn(800));
                $('.commentlist').after(nextlink);

            }
        });
    });
});


