<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\ProductionConsumption;
use yii\db\Expression;

/**
 * ProductionConsumptionSearch represents the model behind the search form about `common\models\c2\entity\ProductionConsumption`.
 */
class ProductionConsumptionSearch extends ProductionConsumption
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'schedule_id', 'schedule_item_id', 'need_product_id', 'position'], 'integer'],
            [['need_product_sku', 'need_product_name', 'need_product_label', 'need_product_value', 'memo', 'state', 'status', 'created_at', 'updated_at'], 'safe'],
            [['need_number', 'need_sum', 'send_sum'], 'number'],
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
        $query = ProductionConsumption::find();

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
            'schedule_id' => $this->schedule_id,
            'schedule_item_id' => $this->schedule_item_id,
            'need_product_id' => $this->need_product_id,
            'need_number' => $this->need_number,
            'need_sum' => $this->need_sum,
            'send_sum' => $this->send_sum,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'need_product_sku', $this->need_product_sku])
            ->andFilterWhere(['like', 'need_product_name', $this->need_product_name])
            ->andFilterWhere(['like', 'need_product_label', $this->need_product_label])
            ->andFilterWhere(['like', 'need_product_value', $this->need_product_value])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'status', $this->status]);


        return $dataProvider;
    }

    public function getPageParamName($splitor = '-')
    {
        $name = "ProductionConsumptionPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }

    public function getSortParamName($splitor = '-')
    {
        $name = "ProductionConsumptionSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
