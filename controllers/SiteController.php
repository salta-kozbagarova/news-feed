<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\forms\user\SignInForm;
use app\models\forms\user\RegistrationForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAuth()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $signInForm       = new SignInForm();
        $registrationForm = new RegistrationForm();

        return $this->render('auth', [
            'signInForm'       => $signInForm,
            'registrationForm' => $registrationForm
        ]);
    }

    public function actionSignIn()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $signInForm       = new SignInForm();

        if ($signInForm->load(Yii::$app->request->post()) && $signInForm->signIn()) {
            return $this->goBack();
        }

        $registrationForm = new RegistrationForm();

        return $this->render('auth', [
            'signInForm'       => $signInForm,
            'registrationForm' => $registrationForm
        ]);
    }

    public function actionRegister()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $registrationForm = new RegistrationForm();
        if ($registrationForm->load(Yii::$app->request->post()) && $registrationForm->register()) {
            return $this->goBack();
        }

        $signInForm       = new SignInForm();
        
        return $this->render('auth', [
            'signInForm'       => $signInForm,
            'registrationForm' => $registrationForm
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAbout()
    {
        if(\Yii::$app->user->can('updatePost'))
            return $this->render('about');
        elseif(\Yii::$app->user->can('createPost'))
        {
            echo 'Can create';
        }
        else
            echo 'false';
        var_dump(\Yii::$app->user);
    }
}
