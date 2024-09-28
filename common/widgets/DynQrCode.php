<?php

namespace common\widgets;

use Yii;
use yii\widgets\InputWidget as YiiInputWidget;

/**
 * 
 * 
 *
 * @author Ben Bi <bennybi@qq.com>
 */
class DynQrCode extends YiiInputWidget {

    public $qrCodeAttribute;
    public $defaultLabel;
    public $readonly = true;
    public $action = 'dyn-qrcode-generate';
    public $linkId;
    public $pjaxId;

    /**
     * @var array widget plugin options.
     */
    public $pluginOptions = [];

    public function init() {
        parent::init();
        $this->pjaxId = !empty($this->pjaxId) ? $this->pjaxId : $this->qrCodeAttribute . "-dyn-qrcode-pjax";
        $this->linkId = !empty($this->linkId) ? $this->linkId : $this->qrCodeAttribute . "-dyn-qrcode-link";
    }

    public function run() {
        return $this->render('DynQrCode');
    }

}
