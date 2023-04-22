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

    
class TokenController extends Controller
{
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => JwtHttpBearerAuth::class,
                'except' => ['create'],
            ],
        ];
    }

    public function actionCreate()
    {
        $now = new \DateTimeImmutable();
        $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText(Yii::$app->jwt->signingKey));
        $user = Yii::$app->user->identity;
        $token = $config->builder()
            ->issuedBy(Yii::$app->request->hostInfo)
            ->permittedFor(Yii::$app->request->hostInfo)
            ->identifiedBy('64425cb31c2d42406fab3118')// _id пользователя
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('username', 'Peter') // Имя пользователя
            ->getToken($config->signer(), $config->signingKey());

            $response = Yii::$app->getResponse();
            $response->format = Response::FORMAT_JSON;
            $response->data = ['token' => $token->toString()];
            return $response;
    }
}