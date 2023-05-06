<?php

namespace app\modules\api\components;

use Yii;

class JwtValidationData extends \sizeg\jwt\JwtValidationData
{
    /**
     * Initializes the JWT validation data object by setting its ID based on the application's JWT parameters.
     *
     * @inheritdoc
     */
    public function init()
    {
        $jwtParams = Yii::$app->params['jwt'];
        $this->validationData->setId($jwtParams['id']);

        parent::init();
    }
}
