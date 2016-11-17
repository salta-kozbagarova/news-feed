<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\admin\components\Controller;
use app\modules\admin\models\forms\SignInForm;
use app\models\User;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['logout', 'sign-in'],
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['*'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->redirect(['sign-in']);
    }

    public function actionSignIn()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->redirect(['post/index']);
        }

        $signInForm       = new SignInForm();

        if ($signInForm->load(Yii::$app->request->post()) && $signInForm->signIn()) {
            $this->redirect(['post/index']);
        }

        return $this->render('sign-in', [
            'signInForm'       => $signInForm
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        $this->redirect(['default/sign-in']);
    }
}
