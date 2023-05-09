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
        
        $request = Yii::$app->getRequest(); // Get the current request object
        $status = $request->get('status'); // Get the 'status' query parameter from the request
        $tags = $request->get('tags'); // Get the 'tags' query parameter from the request
        $limit = intval($request->get('limit')); // Get the 'limit' query parameter from the request and convert it to an integer
        $sortParam = $request->get('sort'); // Get the 'sort' query parameter from the request
        $page = intval($request->get('page')); // Get the 'page' query parameter from the request and convert it to an integer
        $pop = $request->get('pop'); // Get the 'pop' query parameter from the request
        $collection = Yii::$app->mongodb->getCollection('article'); // Get the MongoDB collection for the 'article' model
        $pipeline = []; // Initialize an empty array to hold the aggregation pipeline
        
        if ($status && $tags) {
            // If both 'status' and 'tags' parameters are provided in the request, add a $match stage to the pipeline to filter by both
            $pipeline[] = ['$match' => ['status' => $status, 'tags' => $tags]];
        } elseif ($status) {
            // If only the 'status' parameter is provided, add a $match stage to the pipeline to filter by it
            $pipeline[] = ['$match' => ['status' => $status]];
        } elseif ($tags) {
            // If only the 'tags' parameter is provided, add a $match stage to the pipeline to filter by it
            $pipeline[] = ['$match' => ['tags' => $tags]];
        }
        
        if ($pop) {
            // If the 'date' parameter is provided, add a series of stages to the pipeline to filter and transform the data accordingly
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
            // If there is a sort parameter, split it by comma to get an array of fields to sort by
            $sort = explode(',', $sortParam);
        
            // Create an empty array to store the fields and sort order
            $sortArray = [];
        
            // Loop through each field in the sort parameter array
            foreach ($sort as $s) {
                // Trim the field to remove any whitespace
                $field = trim($s);
        
                // Check if the field starts with a hyphen to indicate descending order
                if (substr($field, 0, 1) == '-') {
                    // If so, add the field to the sort array with a value of -1 to indicate descending order
                    $sortArray[substr($field, 1)] = -1;
                } else {
                    // If not, add the field to the sort array with a value of 1 to indicate ascending order
                    $sortArray[$field] = 1;
                }
            }
        
            // Add a default sort field of created_at in descending order
            $sortArray['created_at'] = -1;
        
            // Add the $sort pipeline stage to the pipeline array
            $pipeline[] = ['$sort' => $sortArray];
        } else {
            // If there is no sort parameter, sort by created_at in descending order
            $pipeline[] = ['$sort' => ['created_at' => -1]];
        }
        
        if ($page && $limit) {
            // If pagination parameters are provided, add a $skip pipeline stage to skip the correct number of documents
            $pipeline[] = ['$skip' => ($page - 1) * $limit];
        }
        
        if ($limit) {
            // If a limit parameter is provided, add a $limit pipeline stage to limit the number of returned documents
            $pipeline[] = ['$limit' => $limit];
        }
        
        // Run the aggregate query with the constructed pipeline
        $result = $collection->aggregate($pipeline);

        // Return the result as an array
        return $result;
    }

    /**
     * Returns the count of articles in the MongoDB collection that match the given filters.
     *
     * @return int The count of articles.
     */
    public function actionGetCount()
    {
        // Get the filters from the request parameters
        $request = Yii::$app->getRequest();
        $status = $request->get('status');
        $tags = $request->get('tags');
        $pop = $request->get('pop');

        // Get the MongoDB collection and initialize the pipeline
        $collection = Yii::$app->mongodb->getCollection('article');
        $pipeline = [];

        // Add match stage to pipeline based on the given filters
        if ($status && $tags) {
            $pipeline[] = ['$match' => ['status' => $status, 'tags' => $tags]];
        } elseif ($status) {
            $pipeline[] = ['$match' => ['status' => $status]];
        } elseif ($tags) {
            $pipeline[] = ['$match' => ['tags' => $tags]];
        }

        // Add date filtering stages to pipeline if date filter is given
        if ($pop) {
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

        // Add count stage to pipeline
        $pipeline[] = [
            '$count' => 'count'
        ];

        // Execute the pipeline and return the count
        $result = $collection->aggregate($pipeline);
        return isset($result[0]['count']) ? $result[0]['count'] : 0;
    }
}