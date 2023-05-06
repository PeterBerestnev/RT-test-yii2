<?php

namespace app\modules\api\models;

use yii\mongodb\ActiveRecord;

/**
 * RefreshToken is the model class for refresh tokens in the API module.
 */
class RefreshToken extends ActiveRecord
{
    /**
     * Returns the name of the MongoDB collection associated with this ActiveRecord class.
     *
     * @return string the collection name
     */
    public static function collectionName()
    {
        return 'refresh_token';
    }

    /**
     * Returns the list of attribute names for this ActiveRecord class.
     *
     * @return array the list of attribute names
     */
    public function attributes()
    {
        return ['_id', 'urf_userID', 'urf_token', 'urf_ip', 'urf_user_agent', 'urf_created'];
    }
}
