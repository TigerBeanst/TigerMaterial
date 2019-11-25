<?php
//MDUI短代码
function tm_shortcode($content)
{
    //可扩展面板
    $content = str_replace(
        array('[br]', '[panel]', '[/panel]', '[panel-title]', '[panel-title-open]', '[/panel-title]', '[panel-content]', '[/panel-content]'),
        array(
            '<br>',
            '<div class="mdui-panel mdui-panel-gapless" mdui-panel="{accordion: true}">',
            '</div><br>',
            '<div class="mdui-panel-item"><div class="mdui-panel-item-header">',
            '<div class="mdui-panel-item mdui-panel-item-open"><div class="mdui-panel-item-header">',
            '</div>',
            '<div class="mdui-panel-item-body"><p>',
            '</p></div></div>',
        ),
        $content);

    //按钮
    $content = str_replace(
        array('[btn]', '[btn-flat]','[btn-white]','[btn-white-flat]', '[/btn]', '[btn-url]', '[/btn-url]', '[btn-url-new]','[/btn-url-new]'),
        array(
            '<button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-grey-700" ',
            '<button class="mdui-btn mdui-ripple mdui-color-grey-700" ',
            '<button class="mdui-btn mdui-btn-raised mdui-ripple" ',
            '<button class="mdui-btn mdui-ripple" ',
            '</button>',
            "onclick='window.location.href=\"",
            "\"'>",
            "onclick='window.open(\"",
            "\")'>",
        ),
        $content);

    //复选
    $content = str_replace(
        array('[check]','[uncheck]','[/check]'),
        array(
            '<label class="mdui-checkbox"><input type="checkbox" disabled checked/><i class="mdui-checkbox-icon"></i>',
            '<label class="mdui-checkbox"><input type="checkbox" disabled/><i class="mdui-checkbox-icon"></i>',
            '</label>',
        ),
        $content);

    return $content;
}

function panel_function()
{
    return '<div class="mdui-panel mdui-panel-gapless" mdui-panel="{accordion: true}">';
}

function panel_close_function()
{
    return '<div class="mdui-panel mdui-panel-gapless" mdui-panel="{accordion: true}">';
}

add_shortcode('panel', 'panel_function');
add_shortcode('panel-s', 'panel_function');
add_shortcode('/panel', 'panel_close_function');


