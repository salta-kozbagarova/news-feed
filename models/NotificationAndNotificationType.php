<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;


class NotificationAndNotificationType extends ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_and_notification_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_id','notification_type_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => 'ID события',
            'notification_type_id' => 'ID типа уведомления'
        ];
    }

}