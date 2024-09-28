<?php

namespace common\models\c2\search;

use common\models\c2\entity\ProductCategoryRs;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DeptFeUserRs represents the model behind the search form about `common\models\c2\entity\DeptFeUserRs`.
 */
class ProductCategoryRsSearch extends ProductCategoryRs {

    /**
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'product_id', 'category_id', 'position'], 'integer'],
            [['status', 'created_at', 'updated_at',], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = ProductCategoryRs::find();

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
            'product_id' => $this->product_id,
            'category_id' => $this->category_id,
            'position' => $this->position,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;

    }

    public function getPageParamName($splitor = '-') {
        $name = "DeptFeUserRsModelPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }

    public function getSortParamName($splitor = '-') {
        $name = "DeptFeUserRsModelSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }

}
