<?php

namespace app\modules\site;

class SiteModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\site\controllers';

    public function init()
    {
        parent::init();

        $this->layout = 'main';

        \Yii::$app->components = [
            'user'         => [
                'class'           => 'yii\web\User',
                'identityClass'   => 'app\modules\site\models\User',
                'idParam'         => 'rgkproject',
                'enableAutoLogin' => true,
                'loginUrl'        => ['site/default/auth']
            ],
        ];

    }
}
