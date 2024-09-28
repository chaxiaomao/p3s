<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\OrderItemConsumption;

/**
 * OrderItemConsumptionSearch represents the model behind the search form about `common\models\c2\entity\OrderItemConsumption`.
 */
class OrderItemConsumptionSearch extends OrderItemConsumption
{
    public $order_code;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'order_item_id', 'need_product_id', 'sale_product_sum', 'production_sum', 'need_number', 'need_sum', 'position'], 'integer'],
            [['need_product_sku', 'order_code', 'need_product_name', 'need_product_label', 'need_product_value', 'memo', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = OrderItemConsumption::find();

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

        if (!empty($this->order_code)) {
            $query->joinWith([
                'order' => function ($q) {
                    $q->where('{{%order}}.code LIKE "%' . $this->order_code . '%"');
                }
            ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'order_item_id' => $this->order_item_id,
            'need_product_id' => $this->need_product_id,
            'sale_product_sum' => $this->sale_product_sum,
            'production_sum' => $this->production_sum,
            'need_number' => $this->need_number,
            'need_sum' => $this->need_sum,
            'position' => $this->position,
            // 'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'need_product_sku', $this->need_product_sku])
            ->andFilterWhere(['like', 'need_product_name', $this->need_product_name])
            ->andFilterWhere(['like', 'need_product_label', $this->need_product_label])
            ->andFilterWhere(['like', 'need_product_value', $this->need_product_value])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "OrderItemConsumptionPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "OrderItemConsumptionSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
