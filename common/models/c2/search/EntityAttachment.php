<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\EntityAttachment as EntityAttachmentModel;

/**
 * EntityAttachment represents the model behind the search form about `common\models\c2\entity\EntityAttachment`.
 */
class EntityAttachment extends EntityAttachmentModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'entity_id', 'type', 'size', 'status', 'position'], 'integer'],
            [['entity_class', 'entity_attribute', 'name', 'label', 'content', 'hash', 'extension', 'mime_type', 'logic_path', 'created_at', 'updated_at'], 'safe'],
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
        $query = EntityAttachmentModel::find();

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
            'entity_id' => $this->entity_id,
            'type' => $this->type,
            'size' => $this->size,
            'status' => $this->status,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'entity_class', $this->entity_class])
            ->andFilterWhere(['like', 'entity_attribute', $this->entity_attribute])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'hash', $this->hash])
            ->andFilterWhere(['like', 'extension', $this->extension])
            ->andFilterWhere(['like', 'mime_type', $this->mime_type])
            ->andFilterWhere(['like', 'logic_path', $this->logic_path]);

        return $dataProvider;
    }
    
    public function getPageParamName($splitor = '-'){
        $name = "EntityAttachmentModelPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
    
    public function getSortParamName($splitor = '-'){
        $name = "EntityAttachmentModelSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
