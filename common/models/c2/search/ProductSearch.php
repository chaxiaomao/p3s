<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\Product;

/**
 * ProductSearch represents the model behind the search form about `common\models\c2\entity\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'currency_id', 'measure_id', 'sold_count', 'created_by', 'updated_by', 'position'], 'integer'],
            [['type', 'seo_code', 'sku', 'name', 'label', 'value', 'summary', 'description', 'is_released', 'released_at', 'status', 'created_at', 'updated_at'], 'safe'],
            [['low_price', 'sales_price', 'cost_price', 'market_price',], 'number'],
            [['stock'], 'double'],
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
        $query = Product::find();

        $query->with('creator', 'measure');

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
            'low_price' => $this->low_price,
            'sales_price' => $this->sales_price,
            'cost_price' => $this->cost_price,
            'market_price' => $this->market_price,
            'supplier_id' => $this->supplier_id,
            'currency_id' => $this->currency_id,
            'measure_id' => $this->measure_id,
            'sold_count' => $this->sold_count,
            'stock' => $this->stock,
            'released_at' => $this->released_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'position' => $this->position,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'seo_code', $this->seo_code])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'is_released', $this->is_released])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "ProductPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "ProductSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
