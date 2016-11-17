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
class Post extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['content'],'string'],
            [['published'], 'safe'],
            [['author_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Индивидуальный номер',
            'author_id' => 'ID автора',
            'title' => 'Заголовок',
            'content' => 'Содержание',
            'published' => 'Дата публикации',
        ];
    }

    public function isReadByCurrentUser()
    {
        if($this->getUsers()->where(['id'=>Yii::$app->user->identity->id])->one()){
            return true;
        }
        return false;
    }

    public function getShortContent($width=null)
    {
        $shortContent=mb_strimwidth($this->content,0,$width?:200);
        return $shortContent;
    }

    public function getUserPosts()
    {
        return $this->hasMany(UserPost::className(),['post_id'=>'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('user_post', ['post_id'=>'id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id'=>'author_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\AddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\PostQuery(get_called_class());
    }
}
