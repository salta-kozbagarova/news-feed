<?php
namespace app\modules\admin\components;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/assets';

    public $publishOptions = [
        'forceCopy' => true
    ];

    public $css = [
        
    ];

    public $js = [
        //'js/jquery-3.0.0.min.js',
        'js/jquery-ui.min.js',
        //'js/serverSocket.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}