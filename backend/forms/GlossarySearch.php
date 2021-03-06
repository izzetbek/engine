<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Site\Glossary\Glossary;

/**
 * GlossarySearch represents the model behind the search form about `core\entities\Site\Glossary\Glossary`.
 */
class GlossarySearch extends Model
{
    public $draft;
    public $title;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['draft', 'integer'],
            ['title', 'string', 'max' => 255]
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
        $query = Glossary::find()->joinWith('translations');

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

        $query->andFilterWhere(['like', 'glossaryLang.title', $this->title]);

        $query->orderBy('glossaryLang.title');

        return $dataProvider;
    }
}
