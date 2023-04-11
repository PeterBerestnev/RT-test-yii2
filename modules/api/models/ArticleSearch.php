<?php
namespace app\modules\api\models;

use app\models\Article;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * usersSearch represents the model behind the search form about `frontend\models\users`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ['_id', 'title', 'text', 'photo', 'tags', 'date', 'status', 'views','limit'];
    }

    public function rules()
    {
        return [
            [['text', 'status', 'title'], 'string'],
            [['date'], 'datetime','format'=>'short'],
            [['photo'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['tags'], 'string'],
            [['views'], 'integer'],
            [['limit'], 'integer'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find();

        $this->load($params, '');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Pagination' => [
                'pageSize' => $this->limit
            ],
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($params) {
            $query->andFilterWhere(['status' => $this->status])
                ->andFilterWhere(['tags' => $this->tags])
                ->andFilterWhere(['>','date',$this->date]);
        }

        return $dataProvider;
    }
}