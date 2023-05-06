<?php

namespace app\modules\api\controllers;

use Yii;
use yii\filters\Cors;
use yii\rest\Controller;
use app\models\Settings;
use yii\web\ServerErrorHttpException;

class SettingsController extends Controller
{
    // Define allowed HTTP verbs for each action
    protected function verbs()
    {
    }

    // Define behaviors for the controller
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Use JSON Web Token (JWT) authentication for all actions except 'view'
        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => ['view'],
        ];

        // Save authenticator behavior for later use
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // Configure Cross-Origin Resource Sharing (CORS) behavior
        $behaviors['cors'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost'],
                'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Origin' => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '',
                'Access-Control-Allow-Headers' => ['*'],
            ],
        ];

        // Add authenticator behavior back to behaviors array
        $behaviors['authenticator'] = $auth;

        return $behaviors;
    }

    // Retrieve a specific setting by name
    public function actionView($name)
    {   
        $model = Settings::find()->where(["name" => $name])->one();

        // If setting does not exist, create a new instance with default value of 0 and add error message
        if(!isset($model)){
            $model = new Settings;
            $model->name = $name;
            $model->value = 0;
            $model->addError('name', 'Администратору необходимо выставить настройки для:'.$name);
        }

        return $model;    
    }

    // Update a specific setting by name
    public function actionUpdate($name)
    {
        $model = Settings::find()->where(["name" => $name])->one();

        // If setting does not exist, create a new instance with default value of 0
        if(!isset($model)) {
            $model = new Settings;
            $model->name = $name;
            $model->value = 0;
        }

        // Load request data into model and save
        if ($model->load(Yii::$app->getRequest()->getQueryParams(), '') && $model->save()) {
            return $model;
        } else {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
    }
}
