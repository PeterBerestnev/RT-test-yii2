<?php
namespace app\modules\api\actions;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\rest\IndexAction;

class MyIndexAction extends IndexAction
{

    protected function prepareDataProvider()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $filter = null;
        if ($this->dataFilter !== null) {
            $this->dataFilter = Yii::createObject($this->dataFilter);
            if ($this->dataFilter->load($requestParams)) {
                $filter = $this->dataFilter->build();
                if ($filter === false) {
                    return $this->dataFilter;
                }
            }
        }

        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this, $filter);
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        $query = $modelClass::find();
        if (!empty($filter)) {
            $query->andWhere($filter);
        }
        if (is_callable($this->prepareSearchQuery)) {
            $query = call_user_func($this->prepareSearchQuery, $query, $requestParams);
        }

        if (is_array($this->pagination)) {
            $pagination = ArrayHelper::merge(
                [
                    'params' => $requestParams,
                ],
                $this->pagination
            );
        } else {
            $pagination = $this->pagination;
            if ($this->pagination instanceof Pagination) {
                $pagination->params = $requestParams;
            }
        }

        if (is_array($this->sort)) {
            $sort = ArrayHelper::merge(
                [
                    'params' => $requestParams,
                ],
                $this->sort
            );
        } else {
            $sort = $this->sort;
            if ($this->sort instanceof Sort) {
                $sort->params = $requestParams;
            }
        }

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => $pagination,
            'sort' => $sort,
        ]);
    }
}