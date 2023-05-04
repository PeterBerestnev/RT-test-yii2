<?php
namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\Cors;
use app\models\LoginForm;
use app\models\User;

class UserController extends Controller
{

    public function behaviors()
{
    $behaviors = parent::behaviors();



    $behaviors['cors'] = [
        'class' => Cors::class,
        'cors' => [
            'Origin' => ['http://localhost'],
            'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'DELETE', 'OPTIONS'],
            'Access-Control-Allow-Credentials' => true,
            'Access-Control-Allow-Origin' => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '',
            'Access-Control-Allow-Headers' => ['*'],
        ],
    ];
    
 

    return $behaviors;
}

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            $user = $model->getUser();

            $token = $this->generateJwt($user);

            $this->generateRefreshToken($user);

            return [
                'token' => (string) $token,
            ];
        }
        Yii::$app->response->statusCode = 422;

        return [
            'errors' => $model->errors
        ];
    }

    private function generateJwt(\app\models\User $user)
    {
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();

        $jwtParams = Yii::$app->params['jwt'];

        return $jwt->getBuilder()
            // ->issuedBy($jwtParams['issuer'])
            // ->permittedFor($jwtParams['audience'])
            ->identifiedBy($jwtParams['id'], true)
            ->issuedAt($time)
            ->expiresAt($time + $jwtParams['expire'])
            ->withClaim('uid', (string) $user->_id)
            ->getToken($signer, $key);
    }
    /**
     * @throws yii\base\Exception
     */
    private function generateRefreshToken(\app\models\User $user, \app\models\User $impersonator = null): \app\modules\api\models\RefreshToken
    {
        $refreshToken = Yii::$app->security->generateRandomString(200);

        // TODO: Don't always regenerate - you could reuse existing one if user already has one with same IP and user agent
        $userRefreshToken = new \app\modules\api\models\RefreshToken([
            'urf_userID' => (string) $user->_id,
            'urf_token' => $refreshToken,
            'urf_ip' => Yii::$app->request->userIP,
            'urf_user_agent' => Yii::$app->request->userAgent,
            'urf_created' => gmdate('Y-m-d H:i:s'),
        ]);
        if (!$userRefreshToken->save()) {
            throw new \yii\web\ServerErrorHttpException('Failed to save the refresh token: ' . $userRefreshToken->getErrorSummary(true));
        }

        // Send the refresh-token to the user in a HttpOnly cookie that Javascript can never read and that's limited by path
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'refresh-token',
            'value' => $refreshToken,
            'httpOnly' => true,
            'sameSite' => 'none',
            'secure' => true,
            'path' => '/api/user/refresh-token', //endpoint URI for renewing the JWT token using this refresh-token, or deleting refresh-token
        ]));
        return $userRefreshToken;
    }

    public function actionView($id){
        $user = User::findIdentity($id);

     
        return $user->username;
    }
    public function actionRefreshToken()
    {

        $refreshToken = Yii::$app->request->cookies->getValue('refresh-token', false);
        if (!$refreshToken) {
            return new \yii\web\UnauthorizedHttpException('No refresh token found.');
        }
        $userRefreshToken = \app\modules\api\models\RefreshToken::findOne(['urf_token' => $refreshToken]);

        if (Yii::$app->request->getMethod() == 'POST') {
            // Getting new JWT after it has expired
            if (!$userRefreshToken) {
                return new \yii\web\UnauthorizedHttpException('The refresh token no longer exists.');
            }

            $user = \app\models\User::find() //adapt this to your needs
                ->where(['_id' => $userRefreshToken->urf_userID])
                ->one();
            if (!$user) {
                $userRefreshToken->delete();
                return new \yii\web\UnauthorizedHttpException('The user is inactive.');
            }

            $token = $this->generateJwt($user);

            return [
                'status' => 'ok',
                'token' => (string) $token,
            ];

        } elseif (Yii::$app->request->getMethod() == 'DELETE') {
            // Logging out
            if ($userRefreshToken && !$userRefreshToken->delete()) {
                return new \yii\web\ServerErrorHttpException('Failed to delete the refresh token.');
            }

            return ['status' => 'ok'];
        } else {
            return new \yii\web\UnauthorizedHttpException('The user is inactive.');
        }
    }
}