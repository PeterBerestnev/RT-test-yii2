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
use MongoDB\BSON\UTCDateTime;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\BSON\ObjectId;

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
            'except' => ['view', 'index', 'add-view', 'get-count'],
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
     * This method defines the actions that this controller supports. It returns an array of action configurations,
     * where each configuration specifies a different action that this controller handles.
     *
     * @return array an array of action configurations.
     */
    public function actions()
    {
        // Get the default actions supported by the parent class.
        $defaultActions = parent::actions();

        // Add custom configuration for the 'create' action.
        $defaultActions['create'] = [
            'class' => ArticleCreateAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];

        // Add custom configuration for the 'update' action.
        $defaultActions['update'] = [
            'class' => ArticleUpdateAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->updateScenario,
        ];

        // Add custom configuration for the 'delete' action.
        $defaultActions['delete'] = [
            'class' => ArticleDeleteAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        // Remove the 'index' action from the list of supported actions.
        unset($defaultActions['index']);

        // Return the final array of action configurations.
        return $defaultActions;
    }

    /**
     * Adds a new view to the specified article.
     *
     * @param int $id the ID of the article to update.
     * @return Article the updated article model.
     * @throws ServerErrorHttpException if the update fails.
     */
    public function actionAddView($id)
    {
        // Retrieve the article model.
        $model = Article::findOne($id);

        // Get the current UTC datetime.
        $utcDateTime = new UTCDateTime((new \DateTime())->getTimestamp() * 1000);

        // Convert the UTC datetime to a DateTime instance.
        $dateTime = $utcDateTime->toDateTime();

        // Convert the DateTime instance back to a UTC datetime.
        $utcDateTime = new UTCDateTime($dateTime->getTimestamp() * 1000);

        // Add the new view to the article's views array.
        $model->views = array_merge($model->views, [$utcDateTime]);

        // Save the updated article model.
        if (!$model->save()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        // Return the updated article model.
        return $model;
    }


    public function actionIndex()
    {
        $request = Yii::$app->getRequest();
        $status = $request->get('status');
        $tags = $request->get('tags');
        $limit = intval($request->get('limit'));
        $sortParam = $request->get('sort');
        $page = intval($request->get('page'));
        $date = $request->get('date');
        $collection = Yii::$app->mongodb->getCollection('article');
        $pipeline = [];

        if ($status && $tags) {
            $pipeline[] = ['$match' => ['status' => $status, 'tags' => $tags]];
        } elseif ($status) {
            $pipeline[] = ['$match' => ['status' => $status]];
        } elseif ($tags) {
            $pipeline[] = ['$match' => ['tags' => $tags]];
        }

        if ($date) {
            $pipeline[] = ['$unwind' => '$views'];
            $pipeline[] = [
                '$match' => [
                    'views' => [
                        '$gte' => new UTCDateTime((new \DateTime('-1 day'))->getTimestamp() * 1000),
                    ],
                ],
            ];
            $pipeline[] = [
                '$group' => [
                    '_id' => ['$toString' => '$_id'],
                    'title' => ['$first' => '$title'],
                    'text' => ['$first' => '$text'],
                    'views' => ['$sum' => 1],
                    'created_by' => ['$first' => '$created_by'],
                    'updated_by' => ['$first' => '$updated_by'],
                    'created_at' => ['$first' => '$created_at'],
                    'updated_at' => ['$first' => '$updated_at'],
                    'status' => ['$first' => '$status'],
                    'photo' => ['$first' => '$photo'],
                    'tags' => ['$first' => '$tags'],
                    'date' => ['$first' => '$date'],
                ]
            ];
            $pipeline[] = [
                '$project' => [
                    '_id' => ['$toString' => '$_id'],
                    'views' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$views', null]],
                            'then' => '$$REMOVE',
                            'else' => ['$toLong' => '$views']
                        ]
                    ],
                    'title' => 1,
                    'text' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$text', null]],
                            'then' => '$$REMOVE',
                            'else' => '$text'
                        ]
                    ],
                    'status' => 1,
                    'created_by' => ['$toString' => '$created_by'],
                    'photo' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$photo', null]],
                            'then' => '$$REMOVE',
                            'else' => '$photo'
                        ]
                    ],
                    'tags' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$tags', null]],
                            'then' => '$$REMOVE',
                            'else' => '$tags'
                        ]
                    ],
                    'date' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$date', null]],
                            'then' => '$$REMOVE',
                            'else' => ['$toLong' => '$date']
                        ]
                    ],
                    'updated_by' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$updated_by', null]],
                            'then' => '$$REMOVE',
                            'else' => ['$toString' => '$updated_by']
                        ]
                    ],
                    'created_at' => ['$toLong' => '$created_at'],
                    'updated_at' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$updated_at', null]],
                            'then' => '$$REMOVE',
                            'else' => ['$toLong' => '$updated_at']
                        ]
                    ],
                ]
            ];
        } else {
            $pipeline[] = [
                '$project' => [
                    '_id' => ['$toString' => '$_id'],
                    'title' => 1,
                    'text' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$text', null]],
                            'then' => '$$REMOVE',
                            'else' => '$text'
                        ]
                    ],
                    'status' => 1,
                    'created_by' => ['$toString' => '$created_by'],
                    'photo' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$photo', null]],
                            'then' => '$$REMOVE',
                            'else' => '$photo'
                        ]
                    ],
                    'tags' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$tags', null]],
                            'then' => '$$REMOVE',
                            'else' => '$tags'
                        ]
                    ],
                    'date' => [
                        '$cond' => [
                            'if' => ['$ifNull' => ['$date', false]],
                            'then' => ['$toLong' => '$date'],
                            'else' => '$$REMOVE'
                        ]
                    ],
                    'updated_by' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$updated_by', null]],
                            'then' => '$$REMOVE',
                            'else' => ['$toString' => '$updated_by']
                        ]
                    ],
                    'created_at' => ['$toLong' => '$created_at'],
                    'updated_at' => [
                        '$cond' => [
                            'if' => ['$ifNull' => ['$updated_at', false]],
                            'then' => ['$toLong' => '$updated_at'],
                            'else' => '$$REMOVE'
                        ]
                    ]
                ]
            ];
        }

        if ($sortParam) {
            $sort = explode(',', $sortParam);
            $sortArray = [];
            foreach ($sort as $s) {
                $field = trim($s);
                if (substr($field, 0, 1) == '-') {
                    $sortArray[substr($field, 1)] = -1;
                } else {
                    $sortArray[$field] = 1;
                }
            }
            $sortArray['created_at'] = -1; // добавляем сортировку по ID
            $pipeline[] = ['$sort' => $sortArray];
        } else {
            $pipeline[] = ['$sort' => ['created_at' => -1]]; // добавляем сортировку по ID
        }

        if ($page && $limit) {
            $pipeline[] = ['$skip' => ($page - 1) * $limit];
        }

        if ($limit) {
            $pipeline[] = ['$limit' => $limit];
        }

        $result = $collection->aggregate($pipeline);

        // Return the result as an array
        return $result;
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
    public function actionGetCount()
    {
        $request = Yii::$app->getRequest();
        $status = $request->get('status');
        $tags = $request->get('tags');
        $date = $request->get('date');
        $collection = Yii::$app->mongodb->getCollection('article');
        $pipeline = [];
    
        if ($status && $tags) {
            $pipeline[] = ['$match' => ['status' => $status, 'tags' => $tags]];
        } elseif ($status) {
            $pipeline[] = ['$match' => ['status' => $status]];
        } elseif ($tags) {
            $pipeline[] = ['$match' => ['tags' => $tags]];
        }
    
        if ($date) {
            $pipeline[] = ['$unwind' => '$views'];
            $pipeline[] = [
                '$match' => [
                    'views' => [
                        '$gte' => new UTCDateTime((new \DateTime('-1 day'))->getTimestamp() * 1000),
                    ],
                ],
            ];
            $pipeline[] = [
                '$group' => [
                    '_id' => ['$toString' => '$_id'],
                ]
            ];    
        }
    
        $pipeline[] = [
            '$count' => 'count'
        ];
    
        $result = $collection->aggregate($pipeline);
    
        // Return the count
        return isset($result[0]['count']) ? $result[0]['count'] : 0;
    }
}