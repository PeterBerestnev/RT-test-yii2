<?php
namespace app\modules\api\controllers;

use Yii;
use app\models\Article;
use app\modules\api\actions\ArticleCreateAction;
use app\modules\api\actions\ArticleDeleteAction;
use app\modules\api\actions\ArticleUpdateAction;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

class ArticleController extends ActiveController
{
    public $modelClass = Article::class;

    /**
     * Return an empty verbs list to disable default RESTful actions.
     *
     * @return array
     */
    protected function verbs()
    {
        return [];
    }

    /**
     * Define controller behaviors.
     *
     * @return array
     */
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
                'Origin' => [$_ENV['FRONT']],
                'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Origin' => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '',
                'Access-Control-Allow-Headers' => ['*'],
            ],
        ];

        $behaviors['authenticator'] = $auth;

        return $behaviors;
    }

    /**
     * Define controller actions.
     *
     * @return array
     */
    public function actions()
    {
        $defaultActions = parent::actions();
        $defaultActions['create'] = [
            'class' => ArticleCreateAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        $defaultActions['update'] = [
            'class' => ArticleUpdateAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->updateScenario,
        ];
        $defaultActions['delete'] = [
            'class' => ArticleDeleteAction::class,
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

    /**
     * Increment the views count of an article.
     *
     * @param mixed $id id of the article to update.
     * @return Article the updated article.
     * @throws ServerErrorHttpException if the update failed.
     */
    public function actionIncrementViews($id)
    {
        $model = Article::findOne($id);
        $model->views = $model->views + 1;

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }


    /**
     * Retrieves the count of articles filtered by status, tags, and date.
     *
     * @param string|null $status The status of the articles to filter by.
     * @param string|null $tags The tags of the articles to filter by.
     * @param string|null $date The date from which to filter the articles.
     *
     * @return int Returns the count of articles that match the specified filters.
     */
    public function actionGetCount($status = null, $tags = null, $date = null)
    {
        $query = Article::find();

        if ($status !== null) {
            $query->andWhere(['status' => $status]);
        }

        if ($tags !== null) {
            $query->andWhere(['tags' => $tags]);
        }

        if ($date !== null) {
            $query->andWhere(['>=', 'date', $date]);
        }

        return $query->count();
    }
}