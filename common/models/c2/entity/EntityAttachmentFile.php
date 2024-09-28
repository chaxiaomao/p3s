<?php

namespace common\models\c2\entity;

use Yii;
use common\models\c2\statics\EntityAttachmentType;

class EntityAttachmentFile extends EntityAttachment {

    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
        $this->type = EntityAttachmentType::TYPE_FILE;
    }


}
