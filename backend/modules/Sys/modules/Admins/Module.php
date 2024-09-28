<?php

namespace backend\modules\Sys\modules\Admins;

use dektrium\user\Module as BaseModule;

/**
 * Module module definition class
 */
//class Module extends \yii\base\Module
class Module extends BaseModule {

    /**
     * @var string Path to avatar file
     */
    public $avatarPath = '@webroot/images/admins';

    /**
     * @var string URL to avatar file
     */
    public $avatarURL = '@web/images/admins';

    /**
     * @var boolean Captcha
     */
    public $captcha = true;

    /**
     * @var boolean showAlert in views
     */
    public $showAlert = true;

    /**
     * @var boolean showTitles in views
     */
    public $showTitles = true;

    /**
     * @var boolean showTitles in views
     */
    public $socialLogin = false;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        // custom initialization code goes here
    }

}
