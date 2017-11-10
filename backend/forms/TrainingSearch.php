<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Training\Training;

/**
 * TrainingSearch represents the model behind the search form about `core\entities\Training\Training`.
 */
class TrainingSearch extends Model
{
    public $begin_date;
    public $price;
    public $draft;
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['draft', 'integer'],
            ['begin_date', 'date', 'format' => 'php:Y-m-d'],
            ['title', 'safe'],
            ['price', 'number']
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
        $query = Training::find()->joinWith('translations');

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
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'trainingsLang.title', $this->title])
            ->andFilterWhere(['<=', 'begin_date', strtotime($this->begin_date . ' 00:00:00')]);

        return $dataProvider;
    }
}
