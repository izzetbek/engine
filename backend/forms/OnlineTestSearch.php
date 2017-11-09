<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\OnlineTest\Test\OnlineTest;

/**
 * OnlineTestSearch represents the model behind the search form about `core\entities\OnlineTest\Test\OnlineTest`.
 */
class OnlineTestSearch extends Model
{
    public $status;
    public $passed_by;
    public $created_at;
    public $title;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'passed_by', 'created_at'], 'integer'],
            ['title', 'safe'],
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
        $query = OnlineTest::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['>=', 'passed_by', $this->passed_by]);

        return $dataProvider;
    }
}
