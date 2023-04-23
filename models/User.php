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

    const SCENARIO_LOGIN = 'login'; // define the scenario constant

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['username', 'password_hash']; // define the fields for the scenario
        return $scenarios;
    }

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
        $user = self::findOne(['_id' => (string) $token->getClaim('uid')]);
        if ($user !== null) {
            return new static($user->attributes);
        } else {
            return null;
        }
    }

    public static function findByUsername($username)
    {
        return self::find()->andWhere(['username' => $username])->one();
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
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password,$this->password_hash);
    }
}
