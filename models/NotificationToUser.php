<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;


class NotificationToUser extends ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_to_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_id','user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => 'ID события',
            'user_id' => 'ID отправителя'
        ];
    }

    public function getNotification()
    {
        return $this->hasOne(Notification::className(),['id'=>'notification_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

}