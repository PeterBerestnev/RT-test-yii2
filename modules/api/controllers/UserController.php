<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\Cors;
use app\models\LoginForm;
use app\models\User;

class UserController extends Controller
{
    // Set up CORS behavior for the controller
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['cors'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => [$_ENV['FRONT']],
                'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Allow-Origin' => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '',
                'Access-Control-Allow-Headers' => ['*'],
            ],
        ];

        return $behaviors;
    }

    // Handle user login
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            $user = $model->getUser();

            // Generate a JWT for the user
            $token = $this->generateJwt($user);

            // Generate a refresh token for the user
            $this->generateRefreshToken($user);

            // Return the JWT to the user
            return [
                'token' => (string) $token,
            ];
        }

        // Return validation errors if login fails
        Yii::$app->response->statusCode = 422;

        return [
            'errors' => $model->errors
        ];
    }

    // Generate a JWT for the given user
    private function generateJwt(\app\models\User $user)
    {
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();

        $jwtParams = Yii::$app->params['jwt'];

        // Set the JWT claims and return the token
        return $jwt->getBuilder()
            ->identifiedBy($jwtParams['id'], true)
            ->issuedAt($time)
            ->expiresAt($time + $jwtParams['expire'])
            ->withClaim('uid', (string) $user->_id)
            ->getToken($signer, $key);
    }

    // Generate a refresh token for the given user
    /**
     * @throws yii\base\Exception
     */
    private function generateRefreshToken(\app\models\User $user, \app\models\User $impersonator = null): \app\modules\api\models\RefreshToken
    {
        // Generate a random refresh token string
        $refreshToken = Yii::$app->security->generateRandomString(200);

        // Create a new refresh token model
        $userRefreshToken = new \app\modules\api\models\RefreshToken([
            'urf_userID' => (string) $user->_id,
            'urf_token' => $refreshToken,
            'urf_ip' => Yii::$app->request->userIP,
            'urf_user_agent' => Yii::$app->request->userAgent,
            'urf_created' => gmdate('Y-m-d H:i:s'),
        ]);

        // Save the new refresh token to the database
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
            'path' => '/api/user/refresh-token',
        ]));
        
        return $userRefreshToken;
    }

    public function actionView($id)
    {
        // Find user by ID
        $user = User::findIdentity($id);

        // Return username
        return $user->username;
    }

    public function actionRefreshToken()
    {
        // Get refresh token from cookies
        $refreshToken = Yii::$app->request->cookies->getValue('refresh-token', false);

        // Throw exception if refresh token is not found
        if (!$refreshToken) {
            return new \yii\web\UnauthorizedHttpException('No refresh token found.');
        }

        // Find user refresh token by token value
        $userRefreshToken = \app\modules\api\models\RefreshToken::findOne(['urf_token' => $refreshToken]);

        // Generate new JWT if request method is POST
        if (Yii::$app->request->getMethod() === 'POST') {
            // Throw exception if user refresh token is not found
            if (!$userRefreshToken) {
                return new \yii\web\UnauthorizedHttpException('The refresh token no longer exists.');
            }

            // Find user by user ID in refresh token
            $user = \app\models\User::find()
                ->where(['_id' => $userRefreshToken->urf_userID])
                ->one();

            // Throw exception if user is not found
            if (!$user) {
                $userRefreshToken->delete();
                return new \yii\web\UnauthorizedHttpException('The user is inactive.');
            }

            // Generate new JWT token
            $token = $this->generateJwt($user);

            // Return response with new token
            return [
                'status' => 'ok',
                'token' => (string) $token,
            ];
        }
        // Delete user refresh token if request method is DELETE
        elseif (Yii::$app->request->getMethod() == 'DELETE') {
            // Throw exception if user refresh token is not deleted successfully
            if ($userRefreshToken && !$userRefreshToken->delete()) {
                return new \yii\web\ServerErrorHttpException('Failed to delete the refresh token.');
            }

            // Return response with status 'ok'
            return ['status' => 'ok'];
        }
        // Throw exception if request method is neither POST nor DELETE
        else {
            return new \yii\web\UnauthorizedHttpException('The user is inactive.');
        }
    }
}