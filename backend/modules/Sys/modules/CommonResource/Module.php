<?php

namespace backend\modules\Sys\modules\CommonResource;

/**
 * common-resource module definition class
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\Sys\modules\CommonResource\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->modules = [
            'attachment' => ['class' => 'backend\modules\Sys\modules\CommonResource\modules\Attachment\Module'],
        ];
        // custom initialization code goes here
    }

}
