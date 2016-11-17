<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\admin\components\Controller;
use yii\data\ActiveDataProvider;
use app\models\Post;
use app\modules\admin\models\forms\PostForm;
use yii\base\Event;
use yii\web\ForbiddenHttpException;

class PostController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => Yii::$app->user->can('posts.management'),
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
        return $this->render('index',['listDataProvider'=>$dataProvider]);
    }

    /*public function actionCreate()
    {
        $postForm=new PostForm();//::createFromPost(new Post());
   
        if ($postForm->load(Yii::$app->request->post()) && $postForm->save()) {
            
            $postForm->on(PostForm::EVENT_NEW_POST, [$this,'sendNotification'], $postForm->title);
            $postForm->trigger(PostForm::EVENT_NEW_POST);
        }
        
        return $this->render('edit', [
            'postForm'       => $postForm
        ]);
    }*/

    public function actionCreate()
    {
        $model=PostForm::createFromPost(new Post());

        return $this->edit($model);
    }

    public function sendNotification(Event $event)
    {
        $script = <<< JS
        var conn=new WebSocket('ws://localhost:8080');
        conn.onopen=function(e){
            console.log('Connection established!');
            var data='$event->data';
            conn.send(data);
            console.log('Отправлено: '+data);
        };
JS;
        $this->getView()->registerJs($script); 
    }

    /*public function actionCreateAjax()
    {
        Yii::$app->response->format = 'json';
        $postForm=new PostForm();
        if (Yii::$app->request->post()) {
            $postForm->setAttributes(Yii::$app->request->post());
            if($postForm->save()){
                return ['success'=>true];
            }
            else{
                return ['error'=>'not saved'];
            }
        }
        else{
            return ['error'=>'no request'];
        }
    }*/

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = PostForm::createFromPost($this->findModel($id));

        return $this->edit($model);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->is_active = 0;
        if (!$model->save()){
            throw new ModelException($model);
        }

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     *
     * @return User
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        if (($model = Post::findOne($id)) == null) {
            throw new NotFoundHttpException('Post was not found');
        }

        return $model;
    }

    /**
     * @param UserForm $model
     *
     * @return string|\yii\web\Response
     */
    private function edit($model)
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->on(PostForm::EVENT_NEW_POST, [$this,'sendNotification'], $model->title);
            $model->trigger(PostForm::EVENT_NEW_POST);
        }

        return $this->render('edit', [
            'postForm' => $model
        ]);
    }
}
