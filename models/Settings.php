<?php
namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\NotFoundHttpException;

class Settings extends ActiveRecord
{


    public static function collectionName()
    {
        return 'settings';
    }

    public function attributes()
    {
        return ['_id', 'value', 'name'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'integer'],
            [['name'], 'unique']
        ];
    }
    protected function findModel($name)
    {
        if (($model = $this->findOne($name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}