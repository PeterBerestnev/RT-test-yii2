<?php

// <?ace app\components;
namespace app\modules\api\models;
use Yii;

class JwtValidationData extends \sizeg\jwt\Jwt
{
 
 /**
 * @inheritdoc
*/
    public function init()
 { 
 $this->validationData->setIssuer('http://example.com');
 $this->validationData->setAudience('http://example.org');
 $this->validationData->setId('4f1g23a12aa');

 parent::init();
 }
} 