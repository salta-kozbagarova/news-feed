<?php
namespace app\modules\site\components;

use yii\web\AssetBundle;

class SiteAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/site/assets';

    public $publishOptions = [
        'forceCopy' => true
    ];

    public $css = [
        
    ];

    public $js = [
        //'js/jquery-3.0.0.min.js',
        'js/clientSocket.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}