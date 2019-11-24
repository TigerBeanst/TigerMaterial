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
