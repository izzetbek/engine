<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Site\SuccessStory\SuccessStory;

/**
 * StorySearch represents the model behind the search form about `core\entities\Site\SuccessStory\SuccessStory`.
 */
class StorySearch extends Model
{
    public $draft;
    public $company;
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['draft', 'integer'],
            [['name', 'company'], 'safe'],
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
        $query = SuccessStory::find()->joinWith('translations');

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

        $query->andFilterWhere(['like', 'success_storiesLang.name', $this->name])
            ->andFilterWhere(['like', 'company', $this->company]);

        return $dataProvider;
    }
}
