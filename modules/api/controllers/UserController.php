<?php
declare(strict_types=1);
namespace app\modules\api\controllers;

use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Yii;
use yii\rest\Controller;
use bizley\jwt\JwtHttpBearerAuth;
use Lcobucci\JWT\Configuration;
use yii\web\Response;
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
            $now = new \DateTimeImmutable();
            $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText(Yii::$app->jwt->signingKey));

            $token = $config->builder()
                ->issuedBy(Yii::$app->request->hostInfo)
                ->permittedFor(Yii::$app->request->hostInfo)
                ->identifiedBy((string)$user->_id) // _id пользователя
                ->issuedAt($now)
                ->canOnlyBeUsedAfter($now)
                ->expiresAt($now->modify('+1 minute'))
                ->withClaim('username', $user->username) // Имя пользователя
                ->getToken($config->signer(), $config->signingKey());

            $response = Yii::$app->getResponse();
            $response->format = Response::FORMAT_JSON;
            $response->data = ['token' => $token->toString()];
            return $response;
        }

        Yii::$app->response->statusCode = 422;

        return [
            'errors' => $model->errors
        ];
    }
}