<?php

namespace backend\models\c2\entity\rbac;

/**
 * This is the ActiveQuery class for [[BeUser]].
 *
 * @see BeUser
 */
class BeUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BeUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BeUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
