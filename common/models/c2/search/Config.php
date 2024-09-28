<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\Config as ConfigModel;

/**
 * Config represents the model behind the search form about `common\models\c2\entity\Config`.
 */
class Config extends ConfigModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'created_by', 'updated_by', 'status', 'position'], 'integer'],
            [['code', 'label', 'default_value', 'custom_value', 'memo', 'created_at', 'updated_at'], 'safe'],
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
        $query = ConfigModel::find();

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
            'type' => $this->type,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'default_value', $this->default_value])
            ->andFilterWhere(['like', 'custom_value', $this->custom_value])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "ConfigModelPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "ConfigModelSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
