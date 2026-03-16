<?php

namespace backend\models\c2\entity\cl;

use common\models\c2\entity\ProductionScheduleItem;
use common\models\c2\statics\ProductionScheduleState;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\ProductionSchedule;
use yii\db\Expression;

/**
 * ProductionScheduleSearch represents the model behind the search form about `common\models\c2\entity\ProductionSchedule`.
 */
class ProductionScheduleItemSearch extends ProductionScheduleItem
{
    public $total_production;
    public $total_enter_sum;
    public $estimated_ship_date;
    public $actual_ship_date;
    public $occurrence_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'schedule_id', 'product_id', 'combination_id', 'measure_id', 'package_id', 'enter_product_id', 'position'], 'integer'],
            [['created_at', 'updated_at', 'status', 'total_production', 'total_enter_sum', 'estimated_ship_date', 'actual_ship_date', 'occurrence_date'], 'safe'],
            [['product_name', 'product_sku', 'product_label', 'product_value', 'combination_name', 'package_name', 'memo'], 'safe',],
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
            'pagination' => false,
            // 'pagination' => [
            //     'pageParam' => $this->getPageParamName(),
            //     'pageSize' => 20,
            // ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->alias('a');

        $query->select([
            'a.*',
            // 'ps.occurrence_date',
            // 'ps.estimated_ship_date',
            // 'ps.actual_ship_date',
            new Expression('MAX(ps.occurrence_date) as estimated_ship_date'),
            new Expression('MAX(ps.estimated_ship_date) as estimated_ship_date'),
            new Expression('MAX(ps.actual_ship_date) as estimated_ship_date'),
            // new Expression('ANY_VALUE(a.product_sku) as product_sku'),
            // new Expression('ANY_VALUE(a.product_name) as product_name'),
            new Expression('SUM(a.enter_sum) as total_enter_sum'),
            new Expression('SUM(a.production_sum) as total_production'),
        ]);

        $query->leftJoin('{{%production_schedule}} ps', 'ps.id=a.schedule_id');

        $query->with('product.measure');

        $query->where(['like', 'ps.label', 'cl'])
            ->andWhere(['in', 'ps.state', [
                ProductionScheduleState::COMMIT,
                ProductionScheduleState::CALCULATION
            ]]);

        $query->groupBy('a.combination_id');

        $query->orderBy(['ps.position' => SORT_DESC]);

        $query
            ->andFilterWhere(['like', 'product_sku', $this->product_sku])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_label', $this->product_label])
            ->andFilterWhere(['like', 'product_value', $this->product_value]);

        // print_r($query->createCommand()->getRawSql());

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
