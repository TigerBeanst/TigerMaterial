<script src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<?php wp_footer(); ?>
<?php if (!(is_single() || is_page())) { ?>
    <button id="toTop"
            class="mdui-fab mdui-fab-fixed mdui-ripple mdui-color-grey-700" mdui-fab="{trigger: 'click'}"><i
                class="mdui-icon material-icons">expand_less</i>
    </button>
<?php } ?>

<script src="<?php bloginfo('template_url'); ?>/js/mdui.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/infinite-ajax-scroll.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/style-before.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/scrollToTop.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/style.js"></script>
</div>
<footer class="tm-footer mdui-color-white">
    <div class="mdui-float-left mdui-m-l-5">
        <div class="mdui-typo mdui-text-color-grey-500 tm-footer-a">
            <div class="footer-develop-div">Powered by
                <a href="https://cn.wordpress.org/" target="_blank" class="footer-develop-a"
                   title="优雅的个人发布平台">WordPress</a>
                <?php if (getTigerMaterial('tongji_toggle') == 1) { ?><?php if (getTigerMaterial('tongji_text_toggle') == 1) { ?> | <?php } ?><?php echo getTigerMaterial('tongji'); ?><?php } ?>
                <?php if (getTigerMaterial('beian_toggle') == 1) { ?> | <a href="http://beian.miit.gov.cn/"
                                                                           target="_blank"
                                                                           class="footer-develop-a"><?php echo getTigerMaterial('beian'); ?></a><?php } ?>
            </div>
            <div class="footer-develop-div">Theme -
                <a href="https://github.com/hjthjthjt/TigerMaterial" target="_blank"
                   class="footer-develop-a">TigerMaterial</a>
                | <a href="https://jakting.com" target="_blank" class="footer-develop-a">Jartip</a></div>
        </div>
    </div>
    <div class="mdui-float-right mdui-m-l-5">
        <div class="mdui-typo mdui-text-color-grey-500 tm-footer-a">
            <div class="footer-develop-div">Copyright © <?php echo getTigerMaterial('found_year', '2012'); ?> - 2020
                甲烃气瓶
            </div>
            <div class="footer-develop-div">本博客使用
                <a href="<?php echo getTigerMaterial('tm_cc_url', 'https://creativecommons.org/licenses/by-nc-sa/4.0/deed.zh'); ?>"
                   target="_blank" class="footer-develop-a"><?php echo getTigerMaterial('tm_cc_name', 'CC BY-NC-SA 4.0'); ?></a> 进行许可
            </div>
        </div>
    </div>
</footer>
<?php echo getTigerMaterial('diy_js'); ?>
<style><?php echo getTigerMaterial('diy_css'); ?></style>
</html>
