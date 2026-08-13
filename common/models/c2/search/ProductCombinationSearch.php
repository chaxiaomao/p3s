<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\ProductCombination;

/**
 * ProductCombinationSearch represents the model behind the search form about `common\models\c2\entity\ProductCombination`.
 */
class ProductCombinationSearch extends ProductCombination
{
    public $product_name;
    public $sku;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'stock', 'position'], 'integer'],
            [['name', 'label', 'memo', 'status', 'created_at', 'updated_at', 'product_name', 'sku'], 'safe'],
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
        $query = ProductCombination::find();

        $query->with('product');

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

        $query->joinWith([
            'product' => function ($q) {
                $q->where('{{%product}}.sku NOT LIKE "CL-%"');
            }
        ]);

        if (!empty($this->product_name)) {
            $query->joinWith([
                'product' => function ($q) {
                    $q->where('{{%product}}.name LIKE "%' . $this->product_name . '%"');
                }
            ]);
        }

        if (!empty($this->sku)) {
            $query->joinWith([
                'product' => function ($q) {
                    $q->where('{{%product}}.sku LIKE "%' . $this->sku . '%"');
                }
            ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'stock' => $this->stock,
            'position' => $this->position,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "ProductCombinationPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "ProductCombinationSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
