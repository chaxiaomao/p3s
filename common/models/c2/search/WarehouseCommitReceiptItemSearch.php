<?php

namespace common\models\c2\search;

use common\models\c2\entity\WarehouseCommitReceiptItem;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\Warehouse;

/**
 * WarehouseSearch represents the model behind the search form about `common\models\c2\entity\Warehouse`.
 */
class WarehouseCommitReceiptItemSearch extends WarehouseCommitReceiptItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commit_id', 'note_id', 'product_id', 'number', 'position', 'type', 'status', 'state'], 'integer'],
            [['created_at', 'updated_at', 'label', 'memo'], 'safe'],
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
        $query = WarehouseCommitReceiptItem::find();

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
            'commit_id' => $this->commit_id,
            'note_id' => $this->note_id,
            'product_id' => $this->product_id,
            'number' => $this->number,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "WarehouseCommitReceiptItemPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "WarehouseCommitReceiptItemSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
