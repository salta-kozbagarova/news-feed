<?php

namespace app\modules\site\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $role
 * @property integer $is_active
 *
 * @property Consumer[] $consumers
 * @property Deliveryman[] $deliverymen
 * @property OrderStateLog[] $orderStateLogs
 * @property Token[] $tokens
 * @property UserStore[] $userStores
 * @property Store[] $stores
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     *
     */
    const ROLE_ADMIN = 'administrator';

    /**
     *
     */
    const ROLE_USER = 'user';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password','first_name', 'last_name','username'], 'required'],
            [['role'], 'string'],
            [['is_active'], 'integer'],
            [['email', 'password', 'first_name', 'last_name'], 'string', 'max' => 255],
            [['email','username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
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
        ];
    }

    public static function authenticate()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        Yii::$app->authManager->revokeAll(Yii::$app->user->identity->id);
        Yii::$app->authManager->assign(
            Yii::$app->authManager->getRole(Yii::$app->user->identity->role),
            Yii::$app->user->identity->id
        );

        return true;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {
                $this->accessToken = Yii::$app->security->generateRandomString();
            }
     
            return true;
        }
        return false;
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int|string current user ID
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->accessToken;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
