<?php

namespace app\modules\site\models\forms;

use Yii;
use yii\base\Model;
use app\modules\site\models\User;

class RegistrationForm extends Model
{
    public $firstName;

    public $lastName;

    public $username;

    public $email;

    public $password;

    public function rules()
    {
        return [
            [['firstName', 'lastName', 'username', 'email', 'password'], 'required'],
            [['firstName', 'lastName', 'username', 'email', 'password'], 'safe'],
            [['password'], 'string', 'min' => 6],
            [['firstName', 'lastName'], 'notContainNumberValidator'],
            [['email'], 'email']
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'username' => 'Логин',
        ];
    }

    public function notContainNumberValidator($attribute)
    {
        if (preg_match("/[0-9]/", $this->$attribute)) {
            $this->addError($attribute, 'Это поле не должно содержать числа');
        }
    }

    /**
     * @return bool
     * @throws UnauthorizedHttpException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        if (User::find()->where(['username' => $this->username])->count() > 0) {
            $this->addError('username', 'Пользователь с таким логином уже зарегистрирован');
            return false;
        }

        $user             = new User();
        $user->attributes = [
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'email'      => $this->email,
            'username'   => $this->username,
            'role'       => User::ROLE_USER
        ];

        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);

        if (!$user->save() || !$user->refresh()) {
            $this->addErrors($user->errors);

            return false;
        }

        if (!\Yii::$app->user->login($user)) {
            return false;
        }

        return User::authenticate();
    }
}