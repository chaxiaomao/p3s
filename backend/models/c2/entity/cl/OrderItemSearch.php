<?php

namespace backend\models\c2\entity\cl;

use cza\base\models\statics\EntityModelStatus;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\OrderItem;

/**
 * OrderItemSearch represents the model behind the search form about `common\models\c2\entity\OrderItem`.
 */
class OrderItemSearch extends OrderItem
{
    public $order_code;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'send_pieces', 'order_id', 'customer_id', 'product_id', 'combination_id', 'package_id', 'measure_id', 'pieces', 'product_sum', 'produced_number', 'position'], 'integer'],
            [['label', 'order_code', 'product_name', 'product_sku', 'product_label', 'product_value', 'combination_name', 'package_name', 'memo', 'status', 'created_at', 'updated_at'], 'safe'],
            [['price', 'subtotal'], 'number'],
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
        $query = OrderItem::find();

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
        $query->andFilterWhere(['like', 'product_sku', 'cl-']);

        if (!empty($this->order_code)) {
            $query->joinWith([
                'order' => function ($q) {
                    $q->where('{{%order}}.code LIKE "%' . $this->order_code . '%"');
                }
            ]);
            // $query->leftJoin('{{%order}}', 'code LIKE "%' . $this->order_code . '%"');
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'product_id' => $this->product_id,
            'combination_id' => $this->combination_id,
            'package_id' => $this->package_id,
            'measure_id' => $this->measure_id,
            'pieces' => $this->pieces,
            'send_pieces' => $this->send_pieces,
            'product_sum' => $this->product_sum,
            'produced_number' => $this->produced_number,
            'price' => $this->price,
            'subtotal' => $this->subtotal,
            'position' => $this->position,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            // 'status' => EntityModelStatus::STATUS_ACTIVE,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_sku', $this->product_sku])
            ->andFilterWhere(['like', 'product_label', $this->product_label])
            ->andFilterWhere(['like', 'product_value', $this->product_value])
            ->andFilterWhere(['like', 'combination_name', $this->combination_name])
            ->andFilterWhere(['like', 'package_name', $this->package_name])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'memo', $this->memo]);


        // $query->joinWith(['order' => function($query) { $query->from(['order' => '{{%order}}']); }]);
        //
        // $query->andFilterWhere(['LIKE', 'order.code', $this->getAttribute('order.code')]);

        return $dataProvider;
    }

    public function getPageParamName($splitor = '-')
    {
        $name = "OrderItemPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }

    public function getSortParamName($splitor = '-')
    {
        $name = "OrderItemSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
