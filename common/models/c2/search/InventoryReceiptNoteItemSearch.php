<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\InventoryReceiptNoteItem;

/**
 * InventoryReceiptNoteItemSearch represents the model behind the search form about `common\models\c2\entity\InventoryReceiptNoteItem`.
 */
class InventoryReceiptNoteItemSearch extends InventoryReceiptNoteItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'note_id', 'product_id', 'measure_id', 'number', 'position', 'supplier_id'], 'integer'],
            [['product_name', 'product_sku', 'product_label', 'product_value', 'purcharse_order_code', 'memo', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = InventoryReceiptNoteItem::find();

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
            'note_id' => $this->note_id,
            'product_id' => $this->product_id,
            'measure_id' => $this->measure_id,
            'number' => $this->number,
            'supplier_id' => $this->supplier_id,
            'price' => $this->price,
            'subtotal' => $this->subtotal,
            'position' => $this->position,
            // 'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_sku', $this->product_sku])
            ->andFilterWhere(['like', 'product_label', $this->product_label])
            ->andFilterWhere(['like', 'product_value', $this->product_value])
            ->andFilterWhere(['like', 'purcharse_order_code', $this->purcharse_order_code])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "InventoryReceiptNoteItemPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "InventoryReceiptNoteItemSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
