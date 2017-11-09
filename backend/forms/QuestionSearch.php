<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Cabinet\Question;

/**
 * QuestionSearch represents the model behind the search form about `core\entities\Cabinet\Question`.
 */
class QuestionSearch extends Model
{
    public $userId;
    public $webinarId;
    public $ask_date;
    public $status;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'webinarId', 'ask_date', 'status'], 'integer'],
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
        $query = Question::find();

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
            'user_id' => $this->userId,
            'webinar_id' => $this->webinarId,
            'ask_date' => $this->ask_date,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
