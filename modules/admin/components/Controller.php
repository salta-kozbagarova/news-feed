<?php

namespace app\modules\admin\components;

use app\models\User;
use yii\filters\AccessControl;

class Controller extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN,User::ROLE_AUTHOR],
                    ],
                ],
            ],
        ];
    }
}