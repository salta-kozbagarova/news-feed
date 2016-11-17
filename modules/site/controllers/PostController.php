<?php

namespace app\modules\site\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Post;
use app\models\UserPost;
use app\modules\site\models\forms\UserPostForm;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider=new ActiveDataProvider([
            'query'=>Post::find()->where(['is_active'=>1])->orderBy('id DESC'),
            'pagination'=>[
            'pageSize'=>10,
            ],
        ]);
        $request= new \yii\web\Request();
        var_dump('------------------------------------------------
            ----------------------------------------------------------------------------------------------
            ---------------------------------------------------------------------------------------------
            ------------------------------------------------------------------------------------------------
            ----------------------------------------------------------------------------------------------
            ---------------------------------------------------------------------------------------------
            ------------------------------------------------------------------------------------------------
            ----------------------------------------------------------------------------------------------
            ---------------------------------------------------------------------------------------------
            ------------------------------------------------------------------------------------------------
            ----------------------------------------------------------------------------------------------
            ---------------------------------------------------------------------------------------------
            ------------------------------------------------------------------------------------------------
            ----------------------------------------------------------------------------------------------
            ---------------------------------------------------------------------------------------------
            ------------------------------------------------------------------------------------------------'.$request->getPathInfo().$request->getHostInfo());
        return $this->render('index',['listDataProvider'=>$dataProvider]);
    }

    public function actionView($id)
    {
        $model=$this->findModel($id);
        $this->readPost($id);
        return $this->render('view',['model'=>$model]);
    }

    public function actionRead($id)
    {
        $this->readPost($id);
        $this->redirect(['post/index']);
    }

    public function readPost($id)
    {
        $userPostForm=new UserPostForm();
        $userPostForm->post_id=$id;
        $userPostForm->save();
    }

    public function actionTest()
    {
        /*$request= new \yii\web\Request();
        var_dump($request->getPathInfo());*/
        $this->redirect(\yii\helpers\Url::to(['post/index', 'subdomain' => 'demooo']));
    }

    public function findModel($id)
    {
        if (($model = Post::find()->where(['id'=>$id,'is_active'=>1])->one()) == null) {
            throw new NotFoundHttpException('Статья не найдена');
        }

        return $model;
    }
}
