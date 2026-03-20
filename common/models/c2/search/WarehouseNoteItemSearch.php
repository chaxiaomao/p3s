<?php

namespace common\models\c2\search;

use common\models\c2\entity\InventoryReceiptNote;
use common\models\c2\entity\InventoryReceiptNoteItem;
use common\models\c2\entity\WarehouseNote;
use common\models\c2\statics\WarehouseNoteType;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\WarehouseNoteItem;

/**
 * WarehouseNoteItemSearch represents the model behind the search form about `common\models\c2\entity\WarehouseNoteItem`.
 */
class WarehouseNoteItemSearch extends WarehouseNoteItem
{
    // public $supplier_id;
    // public $code;
    public $warehouse_note_type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'note_id', 'ref_note_id', 'measure_id', 'product_id', 'combination_id', 'package_id', 'pieces', 'price',
                'subtotal', 'number', 'position', 'supplier_id', 'combination_id'], 'integer'],
            [['product_name', 'product_sku', 'product_label', 'product_value', 'combination_name', 'package_name',
                'memo', 'status', 'created_at', 'updated_at', 'code', 'warehouse_note_type'], 'safe'],
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
        $query = self::find();
        $this->load($params);

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

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->with('product', 'receiptNote', 'measure', 'supplier');
        $query->select([
            '{{%warehouse_note_item}}.*',
            '{{%warehouse_note}}.type',
        ]);
        $query->leftJoin(WarehouseNote::tableName(), '{{%warehouse_note_item}}.note_id = {{%warehouse_note}}.id');
        // $query->where(['{{%warehouse_note}}.type' => WarehouseNoteType::RECEIPT]);

        $query->andFilterWhere([
            'id' => $this->id,
            'note_id' => $this->note_id,
            '{{%warehouse_note_item}}.ref_note_id' => $this->ref_note_id,
            'measure_id' => $this->measure_id,
            'product_id' => $this->product_id,
            'combination_id' => $this->combination_id,
            'package_id' => $this->package_id,
            'pieces' => $this->pieces,
            'number' => $this->number,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '{{%warehouse_note_item}}.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_sku', $this->product_sku])
            ->andFilterWhere(['like', 'product_label', $this->product_label])
            ->andFilterWhere(['like', 'product_value', $this->product_value])
            ->andFilterWhere(['like', 'combination_name', $this->combination_name])
            ->andFilterWhere(['like', 'package_name', $this->package_name])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchLog($params)
    {
        $query = WarehouseNoteItem::find();
        // $query->with('owner', 'measure');
        // $query->select([
        //     '{{%warehouse_note_item}}.*',
        //     '{{%warehouse_note}}.type',
        //     '{{%warehouse_note}}.ref_note_code',
        // ]);
        // $query->leftJoin(WarehouseNote::tableName(), '{{%warehouse_note_item}}.note_id = {{%warehouse_note}}.id');
        // $query->where(['{{%warehouse_note}}.type' => $this->warehouse_note_type]);

        $query->with(['owner.creator', 'owner.updator', 'measure']);

        $query->joinWith([
            'owner' => function (\yii\db\ActiveQuery $q) {
                if (!empty($this->warehouse_note_type)) {
                    $q->andFilterWhere(['type' => $this->warehouse_note_type]);
                }
            }
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'sortParam' => $this->getSortParamName(),
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
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
            '{{%warehouse_note_item}}.ref_note_id' => $this->ref_note_id,
            'measure_id' => $this->measure_id,
            'product_id' => $this->product_id,
            'combination_id' => $this->combination_id,
            'package_id' => $this->package_id,
            'pieces' => $this->pieces,
            'number' => $this->number,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '{{%warehouse_note_item}}.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_sku', $this->product_sku])
            ->andFilterWhere(['like', 'product_label', $this->product_label])
            ->andFilterWhere(['like', 'product_value', $this->product_value])
            ->andFilterWhere(['like', 'combination_name', $this->combination_name])
            ->andFilterWhere(['like', 'package_name', $this->package_name])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search1($params)
    {
        $query = WarehouseNoteItem::find();
        // $query->with('measure', 'receiptNoteItem');
        $query->with('measure', 'supplier');
        $query->select([
            '{{%warehouse_note_item}}.*',
            '{{%warehouse_note}}.type',
            '{{%inventory_receipt_note}}.supplier_id',
            '{{%inventory_receipt_note}}.code',
            '{{%inventory_receipt_note_item}}.price',
            '{{%inventory_receipt_note_item}}.subtotal',
        ]);
        $query->leftJoin(WarehouseNote::tableName(), '{{%warehouse_note_item}}.note_id = {{%warehouse_note}}.id');
        $query->leftJoin(InventoryReceiptNote::tableName(), '{{%warehouse_note_item}}.ref_note_id = {{%inventory_receipt_note}}.id');
        $query->leftJoin(InventoryReceiptNoteItem::tableName(), '{{%warehouse_note_item}}.ref_note_id = {{%inventory_receipt_note_item}}.note_id and {{%warehouse_note_item}}.product_id = {{%inventory_receipt_note_item}}.product_id');
        $query->where(['{{%warehouse_note}}.type' => WarehouseNoteType::RECEIPT]);

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
            '{{%inventory_receipt_note}}.supplier_id' => $this->supplier_id,
            '{{%warehouse_note_item}}.ref_note_id' => $this->ref_note_id,
            'measure_id' => $this->measure_id,
            'product_id' => $this->product_id,
            'combination_id' => $this->combination_id,
            'package_id' => $this->package_id,
            'pieces' => $this->pieces,
            'number' => $this->number,
            '{{%inventory_receipt_note_item}}.price' => $this->price,
            '{{%inventory_receipt_note_item}}.subtotal' => $this->subtotal,
            'position' => $this->position,
            // '{{%warehouse_note_item}}.created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '{{%warehouse_note_item}}.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', '{{%warehouse_note_item}}.product_name', $this->product_name])
            ->andFilterWhere(['like', '{{%warehouse_note_item}}.product_sku', $this->product_sku])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', '{{%warehouse_note_item}}.product_label', $this->product_label])
            // ->andFilterWhere(['like', 'product_value', $this->product_value])
            ->andFilterWhere(['like', 'combination_name', $this->combination_name])
            ->andFilterWhere(['like', 'package_name', $this->package_name])
            ->andFilterWhere(['like', '{{%warehouse_note_item}}.created_at', $this->created_at])
            ->andFilterWhere(['like', '{{%inventory_receipt_note}}.memo', $this->memo]);

        return $dataProvider;
    }

    public function getPageParamName($splitor = '-')
    {
        $name = "WarehouseNoteItemPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }

    public function getSortParamName($splitor = '-')
    {
        $name = "WarehouseNoteItemSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
