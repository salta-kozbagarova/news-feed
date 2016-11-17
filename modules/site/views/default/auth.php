<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Authorization';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3 text-center login-form">
            <p>Заполните следующие поля чтобы выполнить вход</p>

            <?php $form = ActiveForm::begin([
                'action' => Url::to(['default/sign-in'])
            ]); ?>

                <?= $form->errorSummary($signInForm); ?>

                <?= $form->field($signInForm, 'username')->textInput(['autofocus' => true])->label(false) ?>

                <?= $form->field($signInForm, 'password')->passwordInput()->label(false) ?>

                <?= $form->field($signInForm, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-xs-12 col-sm-6 register-form">
            <h4 class="f-label color-dark text-center">Вы у нас впервые? Зарегистрируйтесь!</h4>
            <?php
            $form = ActiveForm::begin([
                'action' => Url::to(['default/register'])
            ]);
            ?>
            <?= $form->errorSummary($registrationForm); ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <?php
                    echo $form->field($registrationForm, 'firstName')->textInput([
                        'placeholder' => 'Имя',
                    ])->label(false);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <?php
                    echo $form->field($registrationForm, 'lastName')->textInput([
                        'placeholder' => 'Фамилия',
                    ])->label(false);
                    ?>
                </div>
            </div>

            <?php

            echo $form->field($registrationForm, 'username')
                ->textInput([
                        'placeholder' => 'Логин',
                    ])
                ->label(false);

            echo $form->field($registrationForm, 'email')->textInput([
                        'placeholder' => 'Адрес электронной почты',
                    ])->label(false);

            echo $form->field($registrationForm, 'password', [
                'template' => '<div class="has-feedback input-group">{input}<span class="input-group-addon"><span class="icon-eye"></span></span></div>{error}'
            ])->passwordInput([
                        'placeholder' => 'Пароль',
                    ])->label(false);

            ?>

            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11 pull-left">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success btn-lg sign-in-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    

    
</div>
