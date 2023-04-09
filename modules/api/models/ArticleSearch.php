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
     * @inheritdoc
     */

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
        

        // add conditions that should always apply here
        $this->load($params, '');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Pagination' => [
                'pageSize' => $this->limit
            ],
        ]);
        
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if ($params) {
            // grid filtering conditions

            $query->andFilterWhere(['status' => $this->status])
                ->andFilterWhere(['tags' => $this->tags])
                ->andFilterWhere(['>','date',$this->date]);
        }
        return $dataProvider;
    }
}