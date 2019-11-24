//Ajax 加载文章，加载主体来自 WordPress 官方 Twenty Twelve 主题
let ias = $.ias({
    container: '.container',
    item: '.item',
    pagination: ".navigation",
    next: ".nav-previous a"
});
ias.extension(new IASTriggerExtension({offset: 1}));
ias.extension(new IASSpinnerExtension());
ias.extension(new IASNoneLeftExtension());