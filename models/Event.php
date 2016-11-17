<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class Event extends ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'],'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Индивидуальный номер',
            'name' => 'Имя события'
        ];
    }

    public static function getAllEvents()
    {
        $events = Event::find()->where(['>','id',0])->all();
        return ArrayHelper::map($events,'id','name');
    }

    public function getNotifications()
    {
        return $this->hasMany(Notification::className(),['event_id'=>'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\AddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\EventQuery(get_called_class());
    }

}