<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Article]].
 *
 * @see \app\models\Article
 */
class ArticleQuery extends \yii\mongodb\ActiveQuery
{
    
    /**
     * {@inheritdoc}
     * @return \app\models\Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function limit($limit)
    {
        return $this->limit($limit);
    }
}