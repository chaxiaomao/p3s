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
class QrCode extends YiiInputWidget {

    public $qrCodeAttribute;
    public $qrCodeImageAttribute;
    public $readonly = true;
    public $action = 'qrcode-generate';
    public $linkId = "qr-code-link";
    public $pjaxId = 'qr-code-pjax';

    /**
     * @var array widget plugin options.
     */
    public $pluginOptions = [];

    public function run() {
        return $this->render('QrCode');
    }

}
