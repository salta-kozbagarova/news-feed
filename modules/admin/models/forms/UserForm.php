<?php
namespace app\modules\admin\models\forms;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\base\Event;

/**
 * Class UserForm
 * @package app\models\forms
 */
class UserForm extends Model
{
    const EVENT_BLOCK_USER = 'block_user';

    const EVENT_NEW_USER = 'new_user';

    public $id;

    public $first_name;

    public $last_name;

    public $username;

    public $email;

    public $role;

    public $password;

    public $is_active;

    public $newPassword;

    public $isNewRecord;

    public $old_is_active=0;

    public function init()
    {
        $this->on(self::EVENT_BLOCK_USER, ['self','sendMail'], 'Ваш аккаунт был заблокирован');
        $this->on(self::EVENT_NEW_USER, ['self','sendMail'], 'Ваш аккаунт успешно создан. Спасибо за регистрацию!');
    }

    public function sendMail(Event $event) {
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params->get('adminEmail'))
            ->setTo($this->email)
            ->setSubject('RGK')
            ->setHtmlBody('Уважаемый '.$this->first_name.' '.$this->last_name.'. '.$event->data.'.')
            ->send();
    }

    /**
     * @param User $user
     *
     * @return UserForm
     */
    public static function createFromUser(User $user)
    {
        $model = new self;

        $model->isNewRecord = $user->isNewRecord;
        $model->id          = $user->id;
        $model->email       = $user->email;
        $model->role        = $user->role;
        $model->first_name  = $user->first_name;
        $model->last_name   = $user->last_name;
        $model->username    = $user->username;
        $model->is_active   = $user->is_active;

        if(!$model->isNewRecord){
            $model->old_is_active=$model->is_active;
        }

        return $model;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['newPassword', 'id'], 'safe'],
            [['first_name', 'last_name', 'username', 'email', 'role'], 'required'],
            [['role'], 'string'],
            [['is_active','old_is_active'], 'boolean'],
            [['first_name', 'last_name', 'username', 'email', 'newPassword'], 'string', 'max' => 255],
            [['email'], 'email']
        ]);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Индивидуальный номер',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'username' => 'Логин',
            'role' => 'Роль',
            'is_active' => 'Активный',
            'newPassword' => 'Новый пароль'
        ];
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $model = $this->id ? User::findOne($this->id) : new User();

        if ($this->newPassword) {
            $model->password = \Yii::$app->getSecurity()->generatePasswordHash($this->newPassword);
        }

        $model->email      = $this->email;
        $model->first_name = $this->first_name;
        $model->last_name  = $this->last_name;
        $model->username   = $this->username;
        $model->role       = $this->role;
        $model->is_active  = $this->is_active;

        if (!($model->save() && $model->refresh())) {
            $this->addErrors($model->errors);
        }

        if(isset($this->old_is_active) && $this->old_is_active==1 && $this->old_is_active!=$model->is_active){
            $this->trigger(self::EVENT_BLOCK_USER);
        }

        if(!$this->id){
            $this->trigger(self::EVENT_NEW_USER);
        }

        return true;
    }
}