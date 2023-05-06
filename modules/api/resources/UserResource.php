<?php

namespace app\modules\api\resources;

use app\models\User;

/**
 * UserResource is a resource class for User model.
 */
class UserResource extends User
{
    /**
     * Returns the fields that should be returned by default when serializing the model.
     *
     * @return array the fields to return
     */
    public function fields()
    {
        return ['_id'];
    }
}
