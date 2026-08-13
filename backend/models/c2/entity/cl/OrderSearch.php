<?php

namespace backend\models\c2\entity\cl;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\Order;

/**
 * OrderSearch represents the model behind the search form about `common\models\c2\entity\Order`.
 */
class OrderSearch extends Order
{
    public $customer_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'created_by', 'updated_by', 'position'], 'integer'],
            [['code', 'label', 'customer_name', 'production_date', 'delivery_date', 'memo', 'state', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = Order::find();

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


        $query->with('customer', 'creator', 'updator', 'updator.profile');

        $query->where(['customer_id' => CL_CUSTOMER_ID]);

        if (!empty($this->customer_name)) {
            $query->leftJoin('{{%fe_user}} c', 'c.id = {{%order}}.customer_id');
        }

        $isCanSearch2024P3SData = Yii::$app->authManager->checkAccess(Yii::$app->user->id, 'P_2024_P3S_DATA');
        if (!$isCanSearch2024P3SData) {
            $query->andFilterWhere(['>', 'created_at', '2024-12-31: 23:59:59']);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'production_date' => $this->production_date,
            'delivery_date' => $this->delivery_date,
            'grand_total' => $this->grand_total,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'position' => $this->position,
            // 'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'username', $this->customer_name])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "OrderPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "OrderSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
