<?php
namespace app\models;

use yii\helpers\Url;
use Yii;
use yii\mongodb\ActiveRecord;

class Article extends ActiveRecord
{
    public function init() 
    {
        parent::init();
        $this->status = 'Не опубликованно';
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
        return ['_id', 'title', 'text', 'photo', 'tags', 'date', 'status', 'views'];
    }

    public function rules()
    {
        return [
            [['text','status','title'], 'string'],
            [['title'],'required'],
            [['date'], 'datetime','format'=>'short'],
            [['photo'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg','mimeTypes' => 'image/jpeg'],
            [['tags'],  'each', 'rule' => ['string']],
            [['views'], 'integer'],
        ];
    }
}