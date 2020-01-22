<?php
$word = block_value("tm-button-word");
$link = block_value("tm-button-link");
$color = block_value("tm-button-color");
if (block_value('tm-button-new')) {
    //新窗口打开
    $onclick = "window.open(\"$link\")";
} else {
    //不是新窗口打开
    $onclick = "window.location.href=\"$link\"";
}


$i = block_value('tm-button-style');
if ($i == "raised-colored") {
    //浮动上色
    echo "<b><i>TM-按钮（浮动上色）</i></b><br>";
    echo "<button class='mdui-btn mdui-btn-raised mdui-ripple mdui-color-grey-700' onclick='$onclick'>$word</button>";
} elseif ($i == "raised-white") {
    //浮动白色
    echo "<b><i>TM-按钮（浮动白色）</i></b><br>";
    echo "<button class='mdui-btn mdui-btn-raised mdui-ripple' onclick='$onclick'>$word</button>";
} elseif ($i == "flat-colored") {
    //扁平上色
    echo "<b><i>TM-按钮（扁平上色）</i></b><br>";
    echo "<button class='mdui-btn mdui-ripple mdui-color-grey-700' onclick='$onclick'>$word</button>";
} elseif ($i == "flat-white") {
    //扁平白色
    echo "<b><i>TM-按钮（扁平白色）</i></b><br>";
    echo "<button class='mdui-btn mdui-ripple' onclick='$onclick'>$word</button>";
} elseif ($i == "raised-custom") {
    //浮动自定义颜色
    echo "<b><i>TM-按钮（浮动自定义颜色）</i></b><br>";
    echo "<button class='mdui-btn mdui-btn-raised mdui-ripple mdui-color-grey-700' onclick='$onclick'>$word</button>";
} elseif ($i == "flat-custom") {
    //扁平自定义颜色
    echo "<b><i>TM-按钮（扁平自定义颜色）</i></b><br>";
    echo "<button class='mdui-btn mdui-ripple $color' onclick='$onclick'>$word</button>";
}
?>