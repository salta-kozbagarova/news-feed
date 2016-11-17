<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\admin\components\Controller;
use yii\data\ActiveDataProvider;
use app\models\User;
use app\modules\admin\models\forms\UserForm;
use yii\base\Event;
use yii\web\NotFoundHttpException;
use yii2vm\components\ModelException;

class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => Yii::$app->user->can('users.management'),
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider=new ActiveDataProvider([
            'query'=>User::find()->where(['>','id',0])->orderBy('id DESC'),
            'pagination'=>[
            'pageSize'=>10,
            ],
        ]);
        return $this->render('index',['listDataProvider'=>$dataProvider]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = UserForm::createFromUser(new User());

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
        $model = UserForm::createFromUser($this->findModel($id));

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
        if (($model = User::findOne($id)) == null) {
            throw new NotFoundHttpException(Yii::t('error', 'User was not found'));
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
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model' => $model
        ]);
    }
}
