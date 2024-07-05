<?php

namespace common\models\c2\search;

use common\models\c2\entity\WarehouseCommitDeliveryItem;
use common\models\c2\entity\WarehouseCommitReceiptItem;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\Warehouse;

/**
 * WarehouseSearch represents the model behind the search form about `common\models\c2\entity\Warehouse`.
 */
class WarehouseCommitDeliveryItemSearch extends WarehouseCommitDeliveryItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commit_id', 'note_id', 'package_id', 'combination_id', 'product_id', 'measure_id', 'pieces',
                'product_sum', 'produce_number', 'stock_number', 'position', 'type', 'status', 'state'], 'integer'],
            [['created_at', 'updated_at', 'label', 'package_name', 'combination_name', 'product_name', 'product_sku', 'product_label', 'product_value', 'memo'], 'string', 'max' => 255],
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
        $query = WarehouseCommitDeliveryItem::find();

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
            'commit_id' => $this->commit_id,
            'note_id' => $this->note_id,
            'product_id' => $this->product_id,
            'package_id' => $this->package_id,
            'combination_id' => $this->combination_id,
            'measure_id' => $this->measure_id,
            'pieces' => $this->pieces,
            'product_sum' => $this->product_sum,
            'produce_number' => $this->produce_number,
            'stock_number' => $this->stock_number,
            'type' => $this->type,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'package_name', $this->package_name])
            ->andFilterWhere(['like', 'combination_name', $this->combination_name])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_sku', $this->product_sku])
            ->andFilterWhere(['like', 'product_label', $this->product_label])
            ->andFilterWhere(['like', 'product_value', $this->product_value])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "WarehouseCommitDeliveryItemPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "WarehouseCommitDeliveryItemSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
