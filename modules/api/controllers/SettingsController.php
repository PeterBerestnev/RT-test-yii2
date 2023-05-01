<?php
namespace app\modules\api\controllers;

use Yii;
use yii\filters\Cors;
use yii\rest\Controller;
use app\models\Settings;
use yii\web\ServerErrorHttpException;

class SettingsController extends Controller
{
    protected function verbs(){}

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => ['view'],
        ];
    
        $auth = $behaviors['authenticator'];

        unset($behaviors['authenticator']);

        $behaviors['cors'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost'],
                'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Origin' => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '',
                'Access-Control-Allow-Headers' => ['*'],
            ],
        ];
        $behaviors['authenticator'] = $auth;

        return $behaviors;
    }
    public function actionView($name)
    {   

        $model = Settings::find()->where(["name" => $name])->one();

        if(!isset($model)){
            $model = new Settings;
            $model->name = $name;
            $model->value = 0;
            $model->addError('name', 'Администратору необходимо выставить настройки для:'.$name);
        }

        return $model;    
    }
    public function actionUpdate($name)
    {
        $model = Settings::find()->where(["name" => $name])->one();
        
        if(!isset($model)) {
            $model = new Settings;
            $model->name = $name;
            $model->value = 0;
        }

        if ($model->load(Yii::$app->getRequest()->getQueryParams(), '') && $model->save()) {
            return $model;
        } else {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
    }
}