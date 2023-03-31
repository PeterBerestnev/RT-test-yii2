<?php
namespace app\modules\api\controllers;

use app\modules\api\models\RegisterForm;
use app\modules\api\resources\UserResource;
use Yii;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;
use app\modules\api\models\LoginForm;


class UserController extends Controller
{
    public function actionLogin()
    {

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return $model->getUser();
        }

        Yii::$app->response->statusCode = 422;
        return [
            'errors' => $model->errors
        ];
    }
}