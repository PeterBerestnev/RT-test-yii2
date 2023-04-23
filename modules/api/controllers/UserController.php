<?php
namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\Cors;
use app\models\LoginForm;

class UserController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'cors' => Cors::class,
        ]);
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            $user = $model->getUser();



            $jwt = Yii::$app->jwt;
            $signer = $jwt->getSigner('HS256');
            $key = $jwt->getKey();
            $time = time();
            $token = $jwt->getBuilder()
                // ->issuedBy('http://example.com') // Configures the issuer (iss claim)
                // ->permittedFor('http://example.org') // Configures the audience (aud claim)
                // ->identifiedBy('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                ->issuedAt($time) // Configures the time that the token was issue (iat claim)
                ->expiresAt($time + 3600) // Configures the expiration time of the token (exp claim)
                ->withClaim('uid', (string)$user->_id) // Configures a new claim, called "uid"
                ->getToken($signer, $key); // Retrieves the generated token

            return $this->asJson([
                'token' => (string) $token,
            ]);
        }

        Yii::$app->response->statusCode = 422;

        return [
            'errors' => $model->errors
        ];
    }
}