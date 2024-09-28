<?php

namespace common\models\c2\query;

use cza\base\models\statics\EntityModelStatus;
use common\models\c2\statics\ConfigType;
/**
 * This is the ActiveQuery class for [[\common\models\c2\entity\Config]].
 *
 * @see \common\models\c2\entity\Config
 */
class ConfigQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\c2\entity\Config[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\entity\Config|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function active() {
        return $this->andWhere(['{{%config}}.status' => EntityModelStatus::STATUS_ACTIVE]);
    }

    public function frequency() {
        return $this->andWhere(['{{%config}}.type' => ConfigType::TYPE_FREQUENCY]);
    }

}
