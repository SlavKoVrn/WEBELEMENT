<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Auto;

/**
 * AutoSearch represents the model behind the search form of `common\models\Auto`.
 */
class AutoSearch extends Auto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'model_id'], 'integer'],
            [['images', 'add', 'mileage', 'price', 'phone'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Auto::find();

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
        if ($this->brand_id > 0){
            $query->andFilterWhere([
                'brand_id' => $this->brand_id,
                'model_id' => $this->model_id,
            ]);
        }

        return $dataProvider;
    }
}
