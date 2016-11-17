<?php
namespace app\modules\admin\models\forms;

use app\models\Notification;
use app\models\Event;
use app\models\NotificationType;
use app\models\NotificationToUser;
use app\models\NotificationAndNotificationType;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Class PostForm
 * @package app\models\forms
 */
class NotificationForm extends Model
{
    public $id;

    public $event_id;

    public $sender_id;

    public $receiver_ids;

    public $type_ids;

    public $title;

    public $message;

    public $isNewRecord;

    public function rules()
    {
        return [
            [['title', 'message'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['message'],'string'],
            [['event_id','sender_id'], 'integer'],
            [['receiver_ids','type_ids'],'safe']
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
            'receiver_ids' => 'ID получателей',
            'type_ids' => 'ID типов',
            'title' => 'Заголовок',
            'message' => 'Текст уведомления'
        ];
    }

    /**
     * @param Post $post
     *
     * @return PostForm
     */
    public static function createFromNotification(Notification $notification)
    {
        $model = new self;

        $model->isNewRecord = $notification->isNewRecord;
        $model->id          = $notification->id;
        $model->event_id    = $notification->event_id;
        $model->sender_id   = $notification->sender_id;
        $model->title       = $notification->title;
        $model->message     = $notification->message;

        if(!$notification->isNewRecord){
            $model->receiver_ids = $notification->userIds;
            $model->type_ids = $notification->typeIds;
        }

        return $model;
    }

    public function save($run=false)
    {
        if(!$this->validate())
            return false;

        $model = $this->id ? Notification::findOne($this->id) : new Notification();
        

        $model->event_id    = $this->event_id;
        $model->sender_id   = $this->sender_id;
        $model->title       = $this->title;
        $model->message     = $this->message;

        if (!($model->save() && $model->refresh())) {
            $this->addErrors($model->errors);
        }

        if($this->id){
            $model->prepareNotificationToUser();
            $model->prepareNotificationAndNotificationType();
        }
        
        foreach ($this->receiver_ids as $receiver) {
            $notificationToUser=new NotificationToUser();
            $notificationToUser->user_id=$receiver;
            $model->link('notificationToUsers',$notificationToUser);
            if(!$notificationToUser->refresh()){
                $this->addErrors($model->errors);
            }
        }

        foreach ($this->type_ids as $type) {
            $notificationAndNotificationType=new NotificationAndNotificationType();
            $notificationAndNotificationType->notification_type_id=$type;
            $model->link('notificationAndNotificationTypes',$notificationAndNotificationType);
            if(!$notificationAndNotificationType->refresh()){
                $this->addErrors($model->errors);
            }
        }

        if($run){
            if(in_array('email', $this->type_ids)){
                $users=User::find()->where('in','id',[$this->receiver_ids])->all();
                foreach ($users as $user) {
                    $receivers_email[]=$user->email;
                }
                Yii::$app->mailer->compose()
                    ->setFrom(User::findOne($this->sender_id)->email)
                    ->setTo($receivers_email)
                    ->setSubject($this->title)
                    ->setHtmlBody($this->message)
                    ->send();
            }
        }
        

        return true;
    }
}