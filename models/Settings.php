<?php

namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Settings is the model class for the "settings" collection in MongoDB.
 */
class Settings extends ActiveRecord
{
    /**
     * Returns the name of the MongoDB collection associated with this model class.
     *
     * @return string the collection name
     */
    public static function collectionName()
    {
        return 'settings';
    }

    /**
     * Returns the list of attribute names for this model.
     *
     * @return array the list of attribute names
     */
    public function attributes()
    {
        return ['_id', 'value', 'name'];
    }

    /**
     * Returns the validation rules for attributes in this model.
     *
     * @return array the validation rules
     */
    public function rules()
    {
        return [
            [['value'], 'integer'],
            [['name'], 'unique']
        ];
    }

    /**
     * Finds a single settings model by name.
     *
     * @param string $name the name of the settings model to find
     * @return Settings the settings model instance
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = $this->findOne($name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
