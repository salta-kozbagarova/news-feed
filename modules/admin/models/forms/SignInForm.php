<?php

namespace app\modules\admin\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * SignInForm is the model behind the login form.
 */
class SignInForm extends Model
{
    public $username;
    public $password;

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'username' => 'Имя пользователя',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
        ];
    }

    /**
     * @return bool
     * @throws \yii2vm\components\ModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function signIn()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = User::findOne(['username' => $this->username]);

        if (!$user || ($user->role !== User::ROLE_ADMIN && $user->role !== User::ROLE_AUTHOR)) {
            $this->addError('email', 'Не верные пароль или логин' );
            return false;
        }

        if (!Yii::$app->getSecurity()->validatePassword($this->password, $user->password)) {
            $this->addError('email', 'Не верные пароль или логин' );

            return false;
        }

        if (!Yii::$app->user->login($user)) {
            return false;
        }

        return User::authenticate();
    }
}
