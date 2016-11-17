<?php

namespace app\modules\admin;

class AdminModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();

        \Yii::$app->components = [
            'user'         => [
                'class'           => 'yii\web\User',
                'identityClass'   => 'app\models\User',
                'idParam'         => 'rgkproject_admin',
                'enableAutoLogin' => true,
                'loginUrl'        => ['admin/default/sign-in']
            ],
        ];

        $this->layout = 'main';
    }
}
