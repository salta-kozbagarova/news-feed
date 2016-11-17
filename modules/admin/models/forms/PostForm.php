<?php
namespace app\modules\admin\models\forms;

use app\models\Post;
use app\models\User;
use Yii;
use yii\base\Model;
use yii\base\Event;

/**
 * Class PostForm
 * @package app\models\forms
 */
class PostForm extends Model
{
    const EVENT_NEW_POST = 'new_post';

    public $id;

    public $author_id;

    public $title;

    public $content;

    public $published;

    public $is_active;

    public $isNewRecord;

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['content'],'string'],
            [['published'], 'safe'],
            [['author_id'], 'integer'],
            [['is_active'],'boolean']
        ];
    }

    public function init()
    {
        $this->on(self::EVENT_NEW_POST, ['self','sendMail']);
    }

    public function sendMail(Event $event) {
        $users=User::getReceiversQuery();
        foreach ($users as $user) {
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($user->email)
                ->setSubject('Новая статья')
                ->setHtmlBody('Уважаемый '.$user->username.' На сайте '.Yii::$app->params['domain'].
                    ' добавлена новая статья '.$this->title.'.\n'.
                    $this->shortContent."<a href='".
                    Yii::$app->params['domain']."site/post/view?id=".$this->id."'>...читать далее</a>")
                ->send();
        }
        
    }

    public function getShortContent($width=null)
    {
        $shortContent=mb_strimwidth($this->content,0,$width?:200);
        return $shortContent;
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
            'is_active' => 'Активный'
        ];
    }

    /**
     * @param Post $post
     *
     * @return PostForm
     */
    public static function createFromPost(Post $post)
    {
        $model = new self;

        $model->isNewRecord = $post->isNewRecord;
        $model->id          = $post->id;
        $model->author_id   = $post->author_id;
        $model->title       = $post->title;
        $model->content     = $post->content;
        $model->published   = $post->published;
        $model->is_active   = $post->is_active;

        return $model;
    }

    public function save()
    {
        if(!$this->validate())
            return false;

        $model = $this->id ? Post::findOne($this->id) : new Post();

        if (!$model->id) {
            $model->author_id = Yii::$app->user->identity->id;
        }

        $model->title       = $this->title;
        $model->content     = $this->content;
        $model->published   = $this->published;
        $model->is_active   = $this->is_active;

        if (!($model->save() && $model->refresh())) {
            $this->addErrors($model->errors);
        }

        return true;
    }
}