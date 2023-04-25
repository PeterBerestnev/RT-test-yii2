<?php
namespace app\modules\api\controllers;

use Yii;
use app\models\Article;
use app\modules\api\actions\MyCreateAction;
use app\modules\api\actions\MyDeleteAction;
use app\modules\api\actions\MyUpdateAction;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

class ArticleController extends ActiveController
{
    public $modelClass = Article::class;

    protected function verbs(){}

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => ['view', 'index', 'increment-views', 'get-count'],
        ];
    
        $auth = $behaviors['authenticator'];
    
        unset($behaviors['authenticator']);
    
        $behaviors['cors'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost'],
                'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Origin' => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '',
                'Access-Control-Allow-Headers' => ['*'],
            ],
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
        $defaultActions['update'] = [
            'class' => MyUpdateAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->updateScenario,
        ];
        $defaultActions['delete'] = [
            'class' => MyDeleteAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $defaultActions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'prepareDataProvider' => function () {
                $searchModel = new \app\modules\api\models\ArticleSearch();
                return $searchModel->search(Yii::$app->request->queryParams);
            },
        ];

        return $defaultActions;
    }

    public function actionIncrementViews($id)
    {
        $model = Article::findOne($id);
        $model->views = $model->views + 1;

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }

    public function actionGetCount($status, $tags)
    {
        if($status == ''){
            $query = Article::find()->count();
        } else if ($status != '' && $tags == ''){
            $query = Article::find()->where(['status' => $status])->count();
        }else if($status != '' && $tags != ''){
            $query = Article::find()->andWhere(['status' => $status])->andWhere(['tags' => $tags])->count();
        }else if ($status == '' && $tags != ''){
            $query = Article::find()->where(['tags' => $tags])->count();
        }else if ($status == '' && $tags == ''){
            $query = Article::find()->count();
        }

        return $query;
    }
}