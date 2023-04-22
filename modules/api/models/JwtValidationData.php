<?php

// <?ace app\components;
namespace app\modules\api\models;
use Yii;

class JwtValidationData extends \bizley\jwt\Jwt
{
 
 /**
 * @inheritdoc
*/
    public function init()
 { 
 $this->validationData->setIssuer(Yii::$app->request->hostInfo);
 $this->validationData->setAudience(Yii::$app->request->hostInfo);

 parent::init();
 }
} 