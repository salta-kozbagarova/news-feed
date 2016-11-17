<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

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
class UserPost extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID Пользователя',
            'post_id' => 'ID Статьи',
        ];
    }
}
