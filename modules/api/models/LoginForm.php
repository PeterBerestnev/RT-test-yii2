<?php

namespace app\modules\api\models;

use app\modules\api\resources\UserResource;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 */
class LoginForm extends \app\models\LoginForm
{
    /**
     * Finds user by [[username]]
     *
     * @return UserResource|null Returns the UserResource object if user is found, otherwise returns null
     */
    public function getUser()
    {
        // If user has not been loaded yet
        if ($this->_user === false) {
            // Load user resource by username
            $this->_user = UserResource::findByUsername($this->username);
        }

        // Return user resource or null if not found
        return $this->_user;
    }
}
