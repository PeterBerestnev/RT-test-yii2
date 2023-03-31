<?php
namespace app\modules\api\resources;

use app\models\User;

class UserResource extends User
{
    public function fields()
    {
        return ['_id', 'username', 'access_token'];
    }
}