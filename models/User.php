<?php
namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * Class User
 * 
 * @package app/models
 * 
 * @property string $password_hash
 */
class User extends  ActiveRecord implements IdentityInterface
{
    public function attributes()
    {
        return ['_id', 'username', 'email', 'password_hash', 'authKey', 'access_token'];
    }

    public static function collectionName()
    {
        return 'user';
    }
    
    public static function findIdentity($id)
    {
        return static::findOne(['_id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $jwt = \Yii::$app->jwt;
        try {
            $data = $jwt->getParser()->parse((string) $token); // Parses from a string
            $userId = $data->getClaim('sub');
            return static::findOne(['_id' => $userId]);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getId()
    {
        return (string) $this->_id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
}
