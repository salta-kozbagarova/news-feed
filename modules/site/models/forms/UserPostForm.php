<?php

namespace app\modules\site\models\forms;

use Yii;
use yii\base\Model;
use app\models\UserPost;
use app\models\Post;

class UserPostForm extends Model
{
	public $user_id;

	public $post_id;

	public function rules()
	{
		return [
			[['post_id'],'integer']
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

    public function save()
    {
    	if(!$this->validate()){
    		return false;
    	}

    	$post=Post::findOne($this->post_id);
    	if($post && $post->isReadByCurrentUser())
    		return true;

    	$userPost=new UserPost();
    	$userPost->user_id=Yii::$app->user->identity->id;
    	$userPost->post_id=$this->post_id;
    	return $userPost->save();
    }
}