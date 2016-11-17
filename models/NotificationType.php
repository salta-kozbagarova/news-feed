<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class NotificationType extends ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 255],
            [['type'],'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Индивидуальный номер',
            'type' => 'Тип уведомления'
        ];
    }

    public static function getTypes()
    {
        $types=NotificationType::find()->indexBy('id')->all();
        return ArrayHelper::map($types,'id','type');
    }
}