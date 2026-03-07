<?php

namespace backend\modules\P3S\modules\Warehouse;

/**
 * warehouse module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\P3S\modules\Warehouse\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'commit-note' => [
                'class' => 'backend\modules\P3S\modules\Warehouse\modules\CommitNote\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
