<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Webinar\Webinar;

/**
 * WebinarSearch represents the model behind the search form about `core\entities\Webinar\Webinar`.
 */
class WebinarSearch extends Model
{
    public $title;
    public $price;
    public $beginDate;
    public $status;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            ['title', 'safe'],
            ['beginDate', 'date', 'format' => 'php:Y-m-d'],
            [['price'], 'number'],
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
        $query = Webinar::find()->joinWith('translations');

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
            'price' => $this->price,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'translation.title', $this->title])
            ->andFilterWhere(['<=', 'beginDate', strtotime($this->beginDate . ' 00:00:00')]);

        return $dataProvider;
    }
}
