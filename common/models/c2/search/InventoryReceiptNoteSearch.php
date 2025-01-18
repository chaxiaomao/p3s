<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\InventoryReceiptNote;

/**
 * InventoryReceiptNoteSearch represents the model behind the search form about `common\models\c2\entity\InventoryReceiptNote`.
 */
class InventoryReceiptNoteSearch extends InventoryReceiptNote
{
    public $supplier_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'warehouse_id', 'supplier_id', 'updated_by', 'created_by', 'position'], 'integer'],
            [['type', 'supplier_name', 'code', 'label', 'arrival_date', 'occurrence_date', 'arrival_number', 'buyer_name', 'dept_manager_name', 'financial_name', 'receiver_name', 'memo', 'remote_ip', 'state', 'status', 'updated_at', 'created_at'], 'safe'],
            [['grand_total'], 'number'],
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
        $query = InventoryReceiptNote::find();
        $query->with('supplier', 'creator');

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

        $dataProvider->setSort([
            'defaultOrder' => [
                'created_at' => SORT_DESC
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->supplier_name)) {
            $query->leftJoin('{{%supplier}} c', 'c.id = {{%inventory_receipt_note}}.supplier_id');
        }
        
        $isCanSearch2024P3SData = Yii::$app->authManager->checkAccess(Yii::$app->user->id, 'P_2024_P3S_DATA');
        if (!$isCanSearch2024P3SData) {
            $query->where(['>', 'created_at', '2024-12-31: 23:59:59']);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'warehouse_id' => $this->warehouse_id,
            'supplier_id' => $this->supplier_id,
            'arrival_date' => $this->arrival_date,
            'occurrence_date' => $this->occurrence_date,
            'grand_total' => $this->grand_total,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
            'position' => $this->position,
            // 'updated_at' => $this->updated_at,
            // 'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->supplier_name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'arrival_number', $this->arrival_number])
            ->andFilterWhere(['like', 'buyer_name', $this->buyer_name])
            ->andFilterWhere(['like', 'dept_manager_name', $this->dept_manager_name])
            ->andFilterWhere(['like', 'financial_name', $this->financial_name])
            ->andFilterWhere(['like', 'receiver_name', $this->receiver_name])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'remote_ip', $this->remote_ip])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "InventoryReceiptNotePage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "InventoryReceiptNoteSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
