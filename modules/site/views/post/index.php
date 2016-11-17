<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\modules\site\components\SiteAsset;
use yii\helpers\Html;

SiteAsset::register($this);

$this->title = 'Index';

?>

<div class="container">
<div class="row">

  <div class="col-lg-6">
    <?php Pjax::begin();?>
    <?=
    ListView::widget([
      'dataProvider'=>$listDataProvider,
      'options'=>[
        'tag'=>'div',
        'class'=>'list-wrapper',
        'id'=>'list-wrapper',
      ],
      'layout' => "{summary}\n{items}\n{pager}",
      'itemView'=>function($model,$key,$index,$widget){
        return $this->render('partials/post-list-view',['model'=>$model]);
      },
      
      ]);
    ?>
    <?= Html::a('', ['post/index'], ['class' => 'hidden', 'id'=>'refreshPosts']) ?>
    <?php Pjax::end();?>
  </div>
  <a href="test">here</a>
</div>


    
</div>