<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Site\Article\Article;

/**
 * ArticleSearch represents the model behind the search form about `core\entities\Site\Article\Article`.
 */
class ArticleSearch extends Model
{
    public $date_from;
    public $date_to;
    public $draft;
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['draft', 'integer'],
            ['title', 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
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
        $query = Article::find()->joinWith('translations');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'draft' => $this->draft,
        ]);

        $query->andFilterWhere(['like', 'articlesLang.title', $this->title])
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . '23:59:59') : null]);

        return $dataProvider;
    }
}
