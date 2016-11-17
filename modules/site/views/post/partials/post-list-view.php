<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container">
	<?php
	if($model->isReadByCurrentUser()){
		$divClass="alert alert-success";
		$btnClass="btn btn-success";
	}
	else{
		$divClass="alert alert-warning";
		$btnClass="btn btn-warning";
	}
	?>
	<div class="<?=$divClass?>">
		<div class="row">
			<div class="col-lg-10">
				<h4 class="title"><?=$model->title?></h4>
				<p>-<?=$model->author->first_name.' '.$model->author->last_name?></p>
				<p><?=$model->published?></p>
				<p><?=$model->shortContent?>...
					<?=Html::a('читать далее',Url::to(['post/view', 'id' => $model->id]))?>
				</p>
			</div>
			<div class="col-lg-2">
				<?=Html::a('Прочитано',Url::to(['post/read', 'id' => $model->id]),['class'=>$btnClass])?>
			</div>
		</div>
	
	</div>
	
	
</div>

