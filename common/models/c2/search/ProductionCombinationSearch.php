<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\ProductCombination;

/**
 * ProductionCombinationSearch represents the model behind the search form about `common\models\c2\entity\ProductCombination`.
 */
class ProductionCombinationSearch extends ProductCombination
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'position'], 'integer'],
            [['name', 'label', 'memo', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = ProductCombination::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'sortParam' => $this->getSortParamName(),
            ],
            'pagination' => [
                'pageParam' => $this->getPageParamName(),
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

    public function getPageParamName($splitor = '-')
    {
        $name = "ProductCombinationPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }

    public function getSortParamName($splitor = '-')
    {
        $name = "ProductCombinationSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
