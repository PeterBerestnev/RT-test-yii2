<?php
namespace app\models;

use yii\mongodb\ActiveRecord;
/**
 * Class User
 * 
 * @package app/models
 * 
 * @property string $password_hash
 */
class User extends  ActiveRecord implements \yii\web\IdentityInterface
{


    public function attributes()
    {
        return ['_id', 'username', 'email', 'password_hash', 'authKey', 'access_token'];
    }

    public static function collectionName()
    {
        return 'user';
    }
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($_id)
    {
        return self::findOne($_id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->andWhere(['access_token' => $token])->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     */
    public static function findByUsername($username)
    {
        return self::find()->andWhere(['username' => $username])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password,$this->password_hash);
    }
}
