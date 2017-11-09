<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Site\Team\Team;

/**
 * TeamSearch represents the model behind the search form about `core\entities\Site\Team\Team`.
 */
class TeamSearch extends Model
{
    public $name;
    public $draft;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'draft'], 'safe'],
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
        $query = Team::find()->joinWith('translations');

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

        $query->andFilterWhere(['draft' => $this->draft]);
        // grid filtering conditions
        $query->andFilterWhere(['like', 'teamLang.name', $this->name]);

        return $dataProvider;
    }
}
