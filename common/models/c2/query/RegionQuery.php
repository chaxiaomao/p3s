<?php

namespace common\models\c2\query;
use common\models\c2\statics\RegionType;

/**
 * This is the ActiveQuery class for [[\common\models\c2\entity\RegionModel]].
 *
 * @see \common\models\c2\entity\Region
 */
class RegionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\c2\entity\Region[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\entity\Region|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function provinces() {
        // with "{{%fe_user}}." could avoid errors when join with other table
        return $this->andWhere(['{{%region}}.type' => RegionType::TYPE_PROVINCE]);
    }

    public function citys() {
        // with "{{%fe_user}}." could avoid errors when join with other table
        return $this->andWhere(['{{%region}}.type' => RegionType::TYPE_CITY]);
    }

    public function districts() {
        // with "{{%fe_user}}." could avoid errors when join with other table
        return $this->andWhere(['{{%region}}.type' => RegionType::TYPE_DISTRICT]);
    }

}
