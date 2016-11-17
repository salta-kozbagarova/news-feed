<?php

namespace app\modules\site\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\site\models\forms\SignInForm;
use app\modules\site\models\forms\RegistrationForm;
use app\models\User;
use yii\helpers\Url;

class DefaultController extends Controller
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

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->role === User::ROLE_ADMIN) {
            $this->redirect(['@administratorHome']);
        }
        return parent::beforeAction($action);
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
            $this->redirect(['post/index']);//Url::to(['post/index', 'subdomain' => $signInForm->username])
            
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
            return $this->redirect(['post/index']);
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

        return $this->goHome();//$this->redirect(Url::to(['default/index']));
    }
}
