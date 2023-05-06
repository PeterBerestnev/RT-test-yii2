<?php

namespace app\modules\api\models;

use app\models\Article;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * ArticleSearch represents the model behind the search form for articles.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ['_id', 'title', 'text', 'photo', 'tags', 'date', 'status', 'views', 'limit'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'status', 'title'], 'string'],
            [['photo'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['tags'], 'string'],
            [['views'], 'integer'],
            [['date'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['limit'], 'integer'],
        ];
    }

    /**
     * Validates the format of the datetime attribute.
     *
     * @param string $attribute the attribute being validated
     * @param array $params the additional name-value pairs given in the rule
     *
     * @return void
     */
    public function validateDateTime($attribute, $params)
    {
        $timestamp = strtotime($this->$attribute);
        if ($timestamp === false) {
            $this->addError($attribute, 'Invalid datetime value');
        }
    }

    /**
     * Creates a data provider instance with the search query applied.
     *
     * @param array $params the search parameters
     *
     * @return ActiveDataProvider the data provider with the search query applied
     */
    public function search($params)
    {
        // Create query instance
        $query = Article::find();

        // Load search parameters into model
        $this->load($params, '');

        // Create a new data provider instance
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Pagination' => [
                'pageSize' => $this->limit,
            ],
        ]);

        // If model validation fails, return the data provider instance
        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filter query based on search parameters
        if ($params) {
            $query->andFilterWhere(['status' => $this->status])
                ->andFilterWhere(['tags' => $this->tags])
                ->andFilterWhere(['>', 'date', $this->date]);
        }

        // Return the data provider instance
        return $dataProvider;
    }
}
