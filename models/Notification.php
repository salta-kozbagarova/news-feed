<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;


class Notification extends ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'message'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['message'],'string'],
            [['event_id','sender_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Индивидуальный номер',
            'event_id' => 'ID события',
            'sender_id' => 'ID отправителя',
            'title' => 'Заголовок',
            'message' => 'Текст уведомления',
            'created_at' => 'Создано'
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
                'value' => new Expression('UTC_TIMESTAMP'),
            ]
        ];
    }

    public function beforeDelete()
    {
        $this->unlinkAll('notificationToUsers', true);
        $this->unlinkAll('notificationAndNotificationTypes', true);
        return parent::beforeDelete();
    }

    public function getUserIds()
    {
        return ArrayHelper::getColumn($this->users,'id');
    }

    public function getTypeIds()
    {
        return ArrayHelper::getColumn($this->notificationTypes,'id');
    }

    public function prepareNotificationToUser()
    {
        if($this->unlinkAll('notificationToUsers', true))
            return true;
        return false;
    }

    public function prepareNotificationAndNotificationType()
    {
        if($this->unlinkAll('notificationAndNotificationTypes', true))
            return true;
        return false;
    }

    public function getSender()
    {
        return $this->hasOne(User::className(),['id'=>'sender_id']);
    }

    public function getEvent()
    {
        return $this->hasOne(Event::className(),['id'=>'event_id']);
    }

    public function getNotificationToUsers()
    {
        return $this->hasMany(NotificationToUser::className(),['notification_id'=>'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('notification_to_user',['notification_id'=>'id']);
    }

    public function getNotificationAndNotificationTypes()
    {
    	return $this->hasMany(NotificationAndNotificationType::className(),['notification_id'=>'id']);
    }

    public function getNotificationTypes()
    {
        return $this->hasMany(NotificationType::className(), ['id' => 'notification_type_id'])
            ->viaTable('notification_and_notification_type',['notification_id'=>'id']);
    }
}