<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\widgets\ListView;
use yii\grid\GridView;
use dosamigos\editable\Editable;
use yii\grid\SerialColumn;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Index';

?>

<div class="container">
    <div class="row">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?=Html::a('Создать пользователя',['user/create'],['class'=>'btn btn-success'])?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
            
                <?=
                GridView::widget([
                'dataProvider' => $listDataProvider,
                'layout'       => '{summary} {items} {pager}',
                'showHeader' => true,
                'columns'      => [
                    ['class' => SerialColumn::className()],
                    [
                        'attribute' => 'first_name'
                    ],
                    [
                        'attribute' => 'last_name'
                    ],
                    [
                        'attribute' => 'username'
                    ],
                    [
                        'attribute' => 'email'
                    ],
                    [
                        'attribute' => 'role'
                    ],
                    [
                        'attribute' => 'is_active'
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{update}  {delete}',
                        'options' => ['width' => '70px'],
                        
                    ],
                ],
            ]);
                ?>
            </div>
        </div>
        
    </div>
    

    
</div>
