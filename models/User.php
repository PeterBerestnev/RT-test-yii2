<?php

namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @package app\models
 *
 * @property string $password_hash
 */
class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_LOGIN = 'login'; // constant defining the scenario for logging in

    /**
     * Defines the scenarios for the model
     *
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['username', 'password_hash']; // fields required for the login scenario
        return $scenarios;
    }

    /**
     * Returns the list of attributes for this model
     *
     * @return array
     */
    public function attributes()
    {
        return ['_id', 'username', 'email', 'password_hash', 'authKey', 'access_token'];
    }

    /**
     * Returns the name of the MongoDB collection associated with this model
     *
     * @return string
     */
    public static function collectionName()
    {
        return 'user';
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID. Null should be returned if such an identity cannot be found.
     */
    public static function findIdentity($id)
    {
        return static::findOne(['_id' => $id]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     * @param null $type
     * @return IdentityInterface|null the identity object that matches the given token. Null should be returned if such an identity cannot be found.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::findOne(['_id' => (string) $token->getClaim('uid')]);
        if ($user !== null) {
            return new static($user->attributes);
        } else {
            return null;
        }
    }

    /**
     * Finds a user by their username
     *
     * @param string $username the username to be looked for
     * @return array|null|ActiveRecord
     */
    public static function findByUsername($username)
    {
        return self::find()->andWhere(['username' => $username])->one();
    }

    /**
     * Returns the ID of the user
     *
     * @return string
     */
    public function getId()
    {
        return (string) $this->_id;
    }

    /**
     * Returns the auth key for the user
     *
     * @return mixed
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Validates the auth key for the user
     *
     * @param string $authKey the auth key to be validated
     * @return bool whether the auth key is valid or not
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates the password for the user
     *
     * @param string $password the password to be validated
     * @return bool whether the password is valid or not
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->$this->password_hash);
    }
}