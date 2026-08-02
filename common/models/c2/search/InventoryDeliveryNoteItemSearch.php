<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\InventoryDeliveryNoteItem;

/**
 * InventoryDeliveryNoteItemSearch represents the model behind the search form about `common\models\c2\entity\InventoryDeliveryNoteItem`.
 */
class InventoryDeliveryNoteItemSearch extends InventoryDeliveryNoteItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'note_id', 'customer_id', 'product_id', 'package_id', 'combination_id', 'measure_id', 'pieces', 'product_sum', 'position'], 'integer'],
            [['product_name', 'product_sku', 'package_name', 'combination_name', 'volume', 'weight', 'memo', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = InventoryDeliveryNoteItem::find();

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


        $query->where(['not', ['in', 'customer_id', CL_CUSTOMER_ID]]);

        $query->andFilterWhere([
            'id' => $this->id,
            'note_id' => $this->note_id,
            'customer_id' => $this->customer_id,
            'product_id' => $this->product_id,
            'package_id' => $this->package_id,
            'combination_id' => $this->combination_id,
            'measure_id' => $this->measure_id,
            'pieces' => $this->pieces,
            'product_sum' => $this->product_sum,
            'price' => $this->price,
            'subtotal' => $this->subtotal,
            'position' => $this->position,
            // 'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_sku', $this->product_sku])
            ->andFilterWhere(['like', 'package_name', $this->package_name])
            ->andFilterWhere(['like', 'combination_name', $this->combination_name])
            ->andFilterWhere(['like', 'volume', $this->volume])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "InventoryDeliveryNoteItemPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "InventoryDeliveryNoteItemSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
