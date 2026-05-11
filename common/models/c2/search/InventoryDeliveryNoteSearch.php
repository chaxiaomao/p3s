<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\InventoryDeliveryNote;
use yii\db\ActiveQuery;

/**
 * InventoryDeliveryNoteSearch represents the model behind the search form about `common\models\c2\entity\InventoryDeliveryNote`.
 */
class InventoryDeliveryNoteSearch extends InventoryDeliveryNote
{

    public $customer_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'warehouse_id', 'sales_order_id', 'customer_id', 'audited_by', 'updated_by', 'created_by', 'position'], 'integer'],
            [['type', 'code', 'label', 'customer_name', 'occurrence_date', 'contact_man', 'cs_name', 'sender_name', 'financial_name', 'payment_method', 'delivery_method', 'memo', 'remote_ip', 'is_audited', 'state', 'status', 'updated_at', 'created_at'], 'safe'],
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
        $query = InventoryDeliveryNote::find();

        $query->with('customer', 'creator');

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

        $query->with('customer', 'creator.profile', 'updator.profile');

        $query->where(['not', ['in', 'customer_id', CL_CUSTOMER_ID]]);

        if (!empty($this->customer_name)) {
            $query->leftJoin('{{%fe_user}} c', 'c.id = {{%inventory_delivery_note}}.customer_id');
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'warehouse_id' => $this->warehouse_id,
            'sales_order_id' => $this->sales_order_id,
            'customer_id' => $this->customer_id,
            'occurrence_date' => $this->occurrence_date,
            'grand_total' => $this->grand_total,
            'audited_by' => $this->audited_by,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
            'position' => $this->position,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'username', $this->customer_name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'contact_man', $this->contact_man])
            ->andFilterWhere(['like', 'cs_name', $this->cs_name])
            ->andFilterWhere(['like', 'sender_name', $this->sender_name])
            ->andFilterWhere(['like', 'financial_name', $this->financial_name])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'delivery_method', $this->delivery_method])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'remote_ip', $this->remote_ip])
            ->andFilterWhere(['like', 'is_audited', $this->is_audited])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

    public function getPageParamName($splitor = '-')
    {
        $name = "InventoryDeliveryNotePage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }

    public function getSortParamName($splitor = '-')
    {
        $name = "InventoryDeliveryNoteSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
