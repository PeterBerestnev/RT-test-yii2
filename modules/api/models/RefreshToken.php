<?php
namespace app\modules\api\models;

use yii\mongodb\ActiveRecord;

class RefreshToken extends ActiveRecord
{
    public static function collectionName()
    {
        return 'refresh_token';
    }

    public function attributes()
    {
        return ['_id', 'urf_userID', 'urf_token', 'urf_ip', 'urf_user_agent', 'urf_created'];
    }
}
