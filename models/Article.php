<?php
namespace app\models;

use yii\helpers\Url;
use Yii;
use yii\mongodb\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use MongoDB\BSON\UTCDateTime;

class Article extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                'value' => new UTCDateTime((new \DateTime())->getTimestamp() * 1000),
            ],
        ];
    }

    public function init() 
    {
        parent::init();
        $this->status = 'Не опубликовано';
        $this->views = 0;
    }

    public function afterDelete(){
        parent::afterDelete();
        if($this->photo){
            unlink('img/'.$this->photo);
        }
    }

    public static function collectionName()
    {
        return 'article';
    }

    public function attributes()
    {
        return ['_id', 'title', 'text', 'photo', 'tags', 'date', 'status', 'views', 'created_at', 'updated_at', 'created_by', 'updated_by'];
    }

    public function rules()
    {
        return [
            [['text','status','title'], 'string'],
            [['status'],'in', 'range' => ['Не опубликовано', 'Опубликовано']],
            [['title'],'required'],
            [['photo'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg','mimeTypes' => 'image/jpeg'],
            [['tags'],  'each', 'rule' => ['match', 'pattern' => '/^[a-zA-Z0-9\s]+$/', 'message' => 'Tags can only contain letters, numbers, and spaces.']],
        ];
    }
}