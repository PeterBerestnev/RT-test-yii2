<?php
namespace app\modules\api\models;
use app\models\Article;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\users;

/**
 * usersSearch represents the model behind the search form about `frontend\models\users`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['text','status','title'], 'string'],
            [['date'], 'date'],
            [['photo'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['tags'],'string'],
            [['views'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,'');
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if($params){
        // grid filtering conditions

        $query->orFilterWhere(['tags' => $this->tags])->all();

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['title' => $this->title])
            ->andFilterWhere(['status' => $this->status])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'views', $this->views]);
    }
        return $dataProvider;
    }
}