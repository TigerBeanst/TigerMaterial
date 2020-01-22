<b><i>TM-可扩展面板</i></b><br>
    <div class="mdui-panel mdui-panel-gapless" mdui-panel="{accordion: true}">
        <div class="mdui-panel-item <?php if (block_value('tm-panel-status')) {
            echo 'mdui-panel-item-open';
        } ?>">
            <div class="mdui-panel-item-header"><?php block_field('tm-panel-title'); ?></div>
            <div class="mdui-panel-item-body" <?php if (block_value('tm-panel-status')) {
                echo 'style="height: auto;"';
            } ?>>
                <?php block_field('tm-panel-content'); ?>
            </div>
        </div>
    </div>