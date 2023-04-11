<?php
namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\NotFoundHttpException;

class Settings extends ActiveRecord
{
    public function init()
    {
        parent::init();
        $this->count = 10;
        $this->name = 'count';
    }

    public static function collectionName()
    {
        return 'settings';
    }

    public function attributes()
    {
        return ['_id', 'count', 'name'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count'], 'integer'],
        ];
    }
    protected function findModel($id)
    {
        if (($model = $this->findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}