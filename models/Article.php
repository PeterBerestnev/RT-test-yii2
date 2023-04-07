<?php

namespace app\models;

use yii\data\ActiveDataProvider;
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

    public static function collectionName()
    {
        return 'article';
    }

    public function attributes()
    {
        return ['_id', 'title', 'text', 'photo', 'tags', 'date', 'status', 'views'];
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
            [['photo'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['tags'],  'each', 'rule' => ['string']],
            [['views'], 'integer'],
        ];
    }
//     public function loadImages()
// {
//     $this->photo =  UploadedFile::getInstancesByName('photo');
//     if (!$this->photo || !$this->validate()) {
//         return false;
//     }
//     foreach ($this->photo as $photo) {
//         Juxtapose::newImages($this->id, $photo);
//     }
//     return true;
// }
    
    // /**
    //  * {@inheritdoc}
    //  * @return \app\models\query\ArticleQuery the active query used by this AR class.
    //  */
    // public static function find()
    // {
    //     return new \app\models\query\ArticleQuery(get_called_class());
    // }
    public function search($params)
{
    $query = Article::find();
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    $this->load($params);


    $query->andFilterWhere([
        'tag' => $this->tags,
    ]);

    return $dataProvider;
}
}