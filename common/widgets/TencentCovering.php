<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/11
 * Time: 17:15
 */

namespace common\widgets;

use Yii;
use cza\base\widgets\Widget;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;

class TencentCovering extends Widget {

    public $markerList;
    public $coord;
    public $title;
    public $addr;
    public $mapOptions = [];
    public $showMePos = true;

    public function init() {
        $defaultOptions = [
            'id' => 'container',
            'style' => "min-width:320px;min-height:600px;",
        ];
        $this->options = ArrayHelper::merge($defaultOptions, $this->options);


        $defaultOptions = [
            'id' => 'map-page',
            'width' => '100%',
            'height' => '800px',
            'frameborder' => '0',
            'marker' => $this->markerList,
        ];
        $this->mapOptions = ArrayHelper::merge($defaultOptions, $this->mapOptions);
        parent::init();
    }

}
