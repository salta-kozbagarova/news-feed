<?php

use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\modules\admin\components\AdminAsset;
use yii\widgets\Pjax;
use yii\helpers\Url;

AdminAsset::register($this);
?>
<?php Pjax::begin();?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<?php $form = ActiveForm::begin(); ?>

			<?= $form->field($postForm, 'title')->textInput();?>
			<?= $form->field($postForm, 'content')->textarea();?>
			<?= $form->field($postForm, 'published')->widget(DatePicker::classname(), [
			    'dateFormat' => 'yyyy-MM-dd',
			]) ?>

			<?= $form->field($postForm, 'is_active')->checkbox();?>

			<button class="btn btn-success" id="create"><?=$postForm->isNewRecord?'Create':'Update';?></button>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
<?php Pjax::end();?>