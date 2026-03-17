<?php

namespace backend\models\c2\entity\cl;

use common\models\c2\statics\ProductionScheduleState;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\ProductionSchedule;

/**
 * ProductionScheduleSearch represents the model behind the search form about `common\models\c2\entity\ProductionSchedule`.
 */
class ProductionScheduleSearch1 extends ProductionSchedule
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'updated_by', 'created_by', 'position'], 'integer'],
            [['type', 'producer', 'code', 'label', 'dept_manager_name', 'financial_name', 'occurrence_date',
                'estimated_ship_date', 'actual_ship_date', 'accomplish_date',
                'memo', 'state', 'status', 'updated_at', 'created_at', 'order_state'], 'safe'],
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
                'position' => SORT_DESC,
                'created_at' => SORT_DESC,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->with('creator.profile', 'updator.profile');
        $query->where(['like', 'label', 'cl']);


        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
        ]);

        $query
            ->andFilterWhere(['like', 'occurrence_date', $this->occurrence_date])
            ->andFilterWhere(['like', 'estimated_ship_date', $this->estimated_ship_date])
            ->andFilterWhere(['like', 'actual_ship_date', $this->actual_ship_date])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'producer', $this->producer])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }

    public function getPageParamName($splitor = '-')
    {
        $name = "ProductionSchedulePage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }

    public function getSortParamName($splitor = '-')
    {
        $name = "ProductionScheduleSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
