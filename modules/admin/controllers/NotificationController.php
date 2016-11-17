<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\admin\components\Controller;
use yii\data\ActiveDataProvider;
use app\models\Notification;
use app\models\Event;
use app\modules\admin\models\forms\NotificationForm;
use yii\web\ForbiddenHttpException;

use app\models\User;

class NotificationController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => Yii::$app->user->can('notification.management'),
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider=new ActiveDataProvider([
            'query'=>Notification::find()->where(['>','id',0])->orderBy('id DESC'),
            'pagination'=>[
            'pageSize'=>10,
            ],
        ]);
        return $this->render('index',['listDataProvider'=>$dataProvider]);
    }

    public function actionCreate()
    {
        $model=NotificationForm::createFromNotification(new Notification());

        return $this->edit($model);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = NotificationForm::createFromNotification($this->findModel($id));

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
        if (!$model->delete()){
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
        if (($model = Notification::findOne($id)) == null) {
            throw new NotFoundHttpException('Notification was not found');
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
            $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    public function actionSaveAndRun($id)
    {
        if($notification = Notification::findOne($id)){
            $model=NotificationForm::createFromNotification($notification);
        }
        else{
            $model=NotificationForm::createFromNotification(new Notification());
        }

        if ($model->load(Yii::$app->request->post()) && $model->save(true)) {
            if(in_array('browser', $model->type_ids)){
                $this->sendBrowserNotification(Event::findOne($model->event_id)->name);
            }
            $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model
        ]);

    }

    public function sendBrowserNotification($data)
    {
        $script = <<< JS
        var conn=new WebSocket('ws://localhost:8080');
        conn.onopen=function(e){
            console.log('Connection established!');
            var data='$data';
            conn.send(data);
            console.log('Отправлено: '+data);
        };
JS;
        $this->getView()->registerJs($script); 
    }
}
