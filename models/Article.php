<?php

namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;


class Article extends ActiveRecord
{
    public function init() 
    {
        parent::init();
        $this->status = 'Не опубликованно';
    }

    public static function collectionName()
    {
        return 'article';
    }

    public function attributes()
    {
        return ['_id', 'title', 'text', 'photo', 'tags', 'date', 'status'];
    }
   
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text','status'], 'string'],
            [['title'],'required'],
            [['title'],'unique'],
            [['date'], 'date'],
            [['photo'], 'file','skipOnEmpty' => true,'extensions' => ['png', 'jpg']],
            [['tags'],  'each', 'rule' => ['string']],
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ArticleQuery(get_called_class());
    }
}