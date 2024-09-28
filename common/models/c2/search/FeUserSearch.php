<?php

namespace common\models\c2\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\c2\entity\FeUser;

/**
 * FeUserSearch represents the model behind the search form about `common\models\c2\entity\FeUserModel`.
 */
class FeUserSearch extends FeUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'attributeset_id', 'flags', 'district_id', 'province_id', 'city_id', 'created_by', 'updated_by', 'position'], 'integer'],
            [['username', 'email', 'password_hash', 'auth_key', 'confirmed_at', 'unconfirmed_email', 'blocked_at', 'registration_ip', 'registration_src_type', 'level', 'last_login_at', 'last_login_ip', 'open_id', 'wechat_union_id', 'wechat_open_id', 'mobile_number', 'sms_receipt', 'access_token', 'password_reset_token', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = FeUser::find();

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
            'attributeset_id' => $this->attributeset_id,
            'confirmed_at' => $this->confirmed_at,
            'blocked_at' => $this->blocked_at,
            'flags' => $this->flags,
            'last_login_at' => $this->last_login_at,
            'district_id' => $this->district_id,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'position' => $this->position,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'unconfirmed_email', $this->unconfirmed_email])
            ->andFilterWhere(['like', 'registration_ip', $this->registration_ip])
            ->andFilterWhere(['like', 'registration_src_type', $this->registration_src_type])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'last_login_ip', $this->last_login_ip])
            ->andFilterWhere(['like', 'open_id', $this->open_id])
            ->andFilterWhere(['like', 'wechat_union_id', $this->wechat_union_id])
            ->andFilterWhere(['like', 'wechat_open_id', $this->wechat_open_id])
            ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'sms_receipt', $this->sms_receipt])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['=', 'status', $this->status]);

        return $dataProvider;
    }

    public function getPageParamName($splitor = '-'){
        $name = "FeUserModelPage";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }

    public function getSortParamName($splitor = '-'){
        $name = "FeUserModelSort";
        return \Yii::$app->czaHelper->naming->toSplit($name);
    }
}
