<?php

use app\models\Event;
use app\models\User;
use app\models\NotificationType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \app\modules\admin\models\forms\UserForm $model
 * @var                                          $this yii\web\View
 * @var User                                     $model
 */

$this->title = 'Create a notification';
$submitButton = $model->isNewRecord?'Создать':'Обновить';
$deleteButton = $model->isNewRecord?' hidden':'';
?>

<div class="row">
    <div class="col-xs-6 col-xs-offset-3">
            <h1><?= Html::encode($this->title) ?></h1>

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->errorSummary($model) ?>

                <?= $form->field($model, 'event_id')->dropDownList(
                    Event::getAllEvents(),
                    ['prompt' => 'Select an event']
                ) ?>

                <?= $form->field($model, 'sender_id')->dropDownList(
                    User::getSenders(),
                    ['prompt' => 'Select a sender']
                ) ?>

                <?= $form->field($model, 'receiver_ids')->dropDownList(
                    User::getReceivers(),
                    ['multiple'=>true]
                ) ?>

                <?= $form->field($model, 'title')->textInput()?>
                <?= $form->field($model, 'message')->textInput()?>

                <?= $form->field($model, 'type_ids')->dropDownList(
                    NotificationType::getTypes(),
                    ['multiple'=>true]
                ) ?>

                <?php ActiveForm::end(); ?>
                <div class="row">
                    <div class="col-xs-4">
                        <?= Html::submitButton($submitButton, [
                            'class' => 'btn btn-primary btn-block col-xs-4',
                            'form'  => $form->id
                        ]) ?>
                    </div>
                    <div class="col-xs-4">
                        <?= Html::submitButton($submitButton.' и выполнить', [
                            'class' => 'btn btn-block btn-primary col-xs-4',
                            'form'  => $form->id,
                            'formaction' => ['notification/save-and-run', 'id' => $model->id],
                        ]); ?>
                    </div>
                    <div class="col-xs-4">
                        <?= Html::a('Удалить', ['notification/delete', 'id' => $model->id], [
                            'class' => 'btn btn-block btn-danger'.$deleteButton,
                            'data'  => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method'  => 'post',
                            ],
                        ]); ?>
                    </div>
                </div>
    </div>
</div>