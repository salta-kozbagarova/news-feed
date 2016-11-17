<?php
use yii\bootstrap\Dropdown;

?>

<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Label <b class="caret"></b></a>
    <?php
        echo Dropdown::widget([
            'items' => [
                ['label' => $model->content],
                ['label' => 'DropdownA'],
                ['label' => 'DropdownB'],
            ],
        ]);
    ?>
</div>