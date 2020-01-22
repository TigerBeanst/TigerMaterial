<?php if(block_value("tm-todo-selection-checked")){
    $check = " checked";
}else{
    $check = "";
}?>
<label class="mdui-checkbox"><input type="checkbox" disabled<?php echo $check;?>><i class="mdui-checkbox-icon"></i><?php block_field("tm-todo-selection-word");?></label><br>