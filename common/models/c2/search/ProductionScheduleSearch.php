<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\ProductionSchedule;

/**
 * ProductionScheduleSearch represents the model behind the search form about `common\models\c2\entity\ProductionSchedule`.
 */
class ProductionScheduleSearch extends ProductionSchedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'updated_by', 'created_by', 'position'], 'integer'],
            [['type', 'producer', 'code', 'label', 'dept_manager_name', 'financial_name', 'occurrence_date', 'accomplish_date', 'memo', 'state', 'status', 'updated_at', 'created_at'], 'safe'],
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
        $query = ProductionSchedule::find();

        $query->with('creator');

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
        $query->with('creator.profile', 'updator.profile');

        $query->where(['not like', 'label', 'cl']);
        $query->andWhere(['not like', 'code', 'po']);

        $query->andFilterWhere([
            'id' => $this->id,
            'occurrence_date' => $this->occurrence_date,
            'accomplish_date' => $this->accomplish_date,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
            'position' => $this->position,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'producer', $this->producer])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'dept_manager_name', $this->dept_manager_name])
            ->andFilterWhere(['like', 'financial_name', $this->financial_name])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

    public function getPageParamName($splitor = '-'){
        $name = "ProductionSchedulePage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }

    public function getSortParamName($splitor = '-'){
        $name = "ProductionScheduleSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
