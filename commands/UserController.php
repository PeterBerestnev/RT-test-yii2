<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\helpers\Console;

class UserController extends Controller
{

    public function actionAddUser($username, $password)
    {
        $security = \Yii::$app->security;
        $user = new User();
        $user->username = $username;
        $user->password_hash = $security->generatePasswordHash($password);
        $user->access_token = $security->generateRandomString(255);
        if($user->save()){
            Console::output('saved');
        } else {
            Console::output('NOT saved');
            var_dump($user->errors);
        }
    }
}
