<?php

namespace app\models;

use MongoDB\BSON\UTCDateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\mongodb\ActiveRecord;

class Article extends ActiveRecord
{
    /**
     * Specifies the behaviors that will be attached to the model. In this case, it attaches a TimestampBehavior.
     * This behavior automatically sets the "created_at" and "updated_at" attributes of the model.
     * 
     * @return array the behavior configurations.
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new UTCDateTime((new \DateTime())->getTimestamp() * 1000),
            ],
        ];
    }

    /**
     * Initializes the model after it has been created.
     * In this case, it sets default values for some attributes.
     */
    public function init()
    {
        parent::init();
        $this->status = 'Не опубликовано';
        $this->views = [];
    }

    /**
     * Handles the "afterDelete" event of the model.
     * In this case, it deletes the photo associated with the article if it exists.
     */
    public function afterDelete()
    {
        parent::afterDelete();
        if ($this->photo) {
            unlink('img/' . $this->photo);
        }
    }

    /**
     * Returns the name of the MongoDB collection associated with this model.
     * 
     * @return string the collection name.
     */
    public static function collectionName()
    {
        return 'article';
    }

    /**
     * Returns the list of attribute names of the model.
     * 
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return [
            '_id',
            'title',
            'text',
            'photo',
            'tags',
            'date',
            'status',
            'views',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ];
    }

    /**
     * Returns the validation rules for the model attributes.
     * 
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['text', 'status', 'title'], 'string'],
            [['status'], 'in', 'range' => ['Не опубликовано', 'Опубликовано']],
            [['title'], 'required'],
            [['photo'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg', 'mimeTypes' => 'image/jpeg'],
            [['tags'], 'each', 'rule' => ['match', 'pattern' => '/^[a-zA-Z0-9\s]+$/', 'message' => 'Tags can only contain letters, numbers, and spaces.']],
        ];
    }
}
