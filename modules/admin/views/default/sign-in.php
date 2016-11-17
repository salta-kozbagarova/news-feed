<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Sign In';
?>

<div class="container">

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3 col-xs-offset-4">

            <?php $form = ActiveForm::begin([
                'action' => Url::to(['default/sign-in']),
            ]); ?>

                <?= $form->errorSummary($signInForm); ?>

                <?= $form->field($signInForm, 'username')->textInput(['autofocus' => true,'placeholder'=>'Логин'])->label(false) ?>

                <?= $form->field($signInForm, 'password')->passwordInput(['placeholder'=>'Пароль'])->label(false) ?>


                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    

    
</div>
