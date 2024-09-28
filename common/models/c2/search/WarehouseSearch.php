<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\Warehouse;

/**
 * WarehouseSearch represents the model behind the search form about `common\models\c2\entity\Warehouse`.
 */
class WarehouseSearch extends Warehouse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'eshop_id', 'entity_id', 'country_id', 'province_id', 'city_id', 'district_id', 'area_id', 'position'], 'integer'],
            [['label', 'name', 'code', 'contact_name', 'contact_phone', 'fax', 'entity_class', 'address', 'geo_longitude', 'geo_latitude', 'geo_marker_color', 'state', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = Warehouse::find();

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
            'eshop_id' => $this->eshop_id,
            'entity_id' => $this->entity_id,
            'country_id' => $this->country_id,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'area_id' => $this->area_id,
            'position' => $this->position,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'contact_name', $this->contact_name])
            ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'entity_class', $this->entity_class])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'geo_longitude', $this->geo_longitude])
            ->andFilterWhere(['like', 'geo_latitude', $this->geo_latitude])
            ->andFilterWhere(['like', 'geo_marker_color', $this->geo_marker_color])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "WarehousePage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "WarehouseSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
