<?php
namespace app\modules\api\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
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
        $auth = $behaviors['authenticator'];
        $auth['except'] = ['view'];
        $auth['authMethods'] = [
            HttpBearerAuth::class
        ];

        unset($behaviors['authenticator']);

        $behaviors['cors'] = [
            'class' => Cors::class,
            'cors' => [
                'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Origin' => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '',
            ],
        ];
        $behaviors['authenticator'] = $auth;

        return $behaviors;
    }
    public function actionView()
    {
        $model = Settings::find()->where(["name" => "count"])->one();

        if ($model === null) {
            $model = new Settings;
            $model->save();
            $model = Settings::find()->where(["name" => "count"])->one();

            return $model;
        }

        return $model;    
    }
    public function actionUpdate($id)
    {
        $model = Settings::findOne($id);

        if ($model->load(Yii::$app->getRequest()->getQueryParams(), '') && $model->save()) {
            return $model;
        } else {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
    }
}