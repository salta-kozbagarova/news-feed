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
                <a href="create" class="btn btn-success">Create Post</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
            
                <?=
                GridView::widget([
                    'dataProvider' => $listDataProvider,
                    'layout'       => '{summary} {items} {pager}',
                    'showHeader' => true,
                    'columns'      => [
                        ['class' => SerialColumn::className()],
                        [
                            'attribute' => 'title'
                        ],
                        [
                            'attribute' => 'content'
                        ],
                        [
                            'attribute' => 'published'
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{update} {delete}'
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
        
    </div>
    

    
</div>
