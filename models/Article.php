<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\UploadedFile;
use Yii;
use yii\mongodb\ActiveRecord;


class Article extends ActiveRecord
{
    public function init() 
    {
        parent::init();
        $this->status = 'Не опубликованно';
    }

    public function afterDelete(){
        parent::afterDelete();
        if($this->photo){
            unlink(str_replace(Url::base(true),Yii::$app->basePath.'/web',$this->photo));
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
    // public static function find()
    // {
    //     return new \app\models\query\ArticleQuery(get_called_class());
    // }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text','status'], 'string'],
            [['title'],'required'],
            [['title'],'unique'],
            [['date'], 'datetime','format'=>'short'],
            [['photo'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['tags'],  'each', 'rule' => ['string']],
            [['views'], 'integer'],
        ];
    }
}