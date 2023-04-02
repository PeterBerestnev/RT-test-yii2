<?php
namespace app\modules\api\controllers;


use app\modules\api\actions\MyCreateAction;
use app\modules\api\resources\ArticleResource;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

class ArticleController extends ActiveController
{
    public $modelClass = ArticleResource::class;

    protected function verbs()
    {
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $auth = $behaviors['authenticator'];
        $auth['except'] = ['view', 'index'];
        $auth['authMethods'] = [
            HttpBearerAuth::class
        ];
        unset($behaviors['authenticator']);
        $behaviors['cors'] = [
            'class' => Cors::class,

        ];
        $behaviors['authenticator'] = $auth;

        return $behaviors;
    }
    public function actions()
    {
        $defaultActions = parent::actions();
        $defaultActions['create'] = [
            'class' => MyCreateAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];

        return $defaultActions;
    }
}