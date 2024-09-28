<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\ProductStock;

/**
 * ProductStockSearch represents the model behind the search form about `common\models\c2\entity\ProductStock`.
 */
class ProductStockSearch extends ProductStock
{
    public $product_name;
    public $measure_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'warehouse_id', 'product_id', 'number', 'position',], 'integer'],
            [['state', 'status', 'created_at', 'updated_at', 'product_name'], 'safe'],
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
        $query = ProductStock::find();

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
            'warehouse_id' => $this->warehouse_id,
            'product_id' => $this->product_id,
            'number' => $this->number,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'status', $this->status]);

        if (!empty($this->product_name)) {
            $query->joinWith([
                'product' => function ($q) {
                    $q->where('{{%product}}.name LIKE "%' . $this->product_name . '%"');
                }
            ]);
        }

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "ProductStockPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "ProductStockSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
