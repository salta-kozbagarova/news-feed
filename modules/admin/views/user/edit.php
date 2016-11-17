<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \app\modules\admin\models\forms\UserForm $model
 * @var                                          $this yii\web\View
 * @var User                                     $model
 */

$this->title = $model->isNewRecord ?
    'Create User' :
    'Update User' . ': ' . $model->first_name;
?>

<div class="row">
    <div class="col-xs-6 col-xs-offset-3">
            <h1><?= Html::encode($this->title) ?></h1>

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->errorSummary($model) ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => 'autofocus'])?>
                <?= $form->field($model, 'first_name')->textInput()?>
                <?= $form->field($model, 'last_name')->textInput()?>
                <?= $form->field($model, 'username')->textInput()?>
                <?= $form->field($model, 'role')->dropDownList(
                    User::getRoles(),
                    ['prompt' => 'Select role']
                ) ?>

                <?= $form->field($model, 'newPassword')->passwordInput(); ?>

                <?= $form->field($model, 'is_active')->checkbox(); ?>

                <?= $form->field($model, 'old_is_active')->hiddenInput()->label(false); ?>

                <?php ActiveForm::end(); ?>
                <div class="row">
                    <div class="col-xs-6">
                        <?= Html::submitButton('Обновить', [
                            'class' => 'btn btn-primary btn-block col-xs-6',
                            'form'  => $form->id
                        ]) ?>
                    </div>
                    <div class="col-xs-6">
                        <?= Html::a('Удалить', ['user/delete', 'id' => $model->id], [
                            'class' => 'btn btn-block btn-danger',
                            'data'  => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method'  => 'post',
                            ],
                        ]); ?>
                    </div>
                </div>
    </div>
</div>