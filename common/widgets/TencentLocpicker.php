<?php

namespace common\widgets;

use Yii;
use cza\base\widgets\Widget;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;

/**
 *  TencentLocpicker Widget
 *  refer to http://lbs.qq.com/tool/component-picker.html
 * @author Ben Bi <bennybi@qq.com>
 * @license
 */
class TencentLocpicker extends Widget {

    public $apiLink = "https://apis.map.qq.com/tools/locpicker?search={search}&type={type}&key={key}&referer={referer}&zoom={zoom}&coordtype={coordtype}";
    public $search = 1;
    public $type = 1;
    public $key;
    public $zoom = 16;
    public $coordtype = 5;
    public $coord;  // format example: coord=40.022964,116.319723
    public $referer = 'myapp';
    public $mapOptions = [];

    public function init() {
        $defaultOptions = [
            'id' => 'map-container',
            'class' => 'map',
        ];
        $this->options = ArrayHelper::merge($defaultOptions, $this->options);

        $this->apiLink = strtr($this->apiLink, [
            '{search}' => $this->search,
            '{type}' => $this->type,
            '{key}' => $this->key,
            '{referer}' => $this->referer,
            '{zoom}' => $this->zoom,
            '{coordtype}' => $this->coordtype,
        ]);
       
        if(!empty($this->coord)){
            $this->apiLink.= "&coord={$this->coord}";
        }

        $defaultOptions = [
            'id' => 'map-page',
            'width' => '100%',
            'height' => '800px',
            'frameborder' => '0',
            'src' =>$this->apiLink,
        ];
        $this->mapOptions = ArrayHelper::merge($defaultOptions, $this->mapOptions);
        parent::init();

    }

//    public function run() {
//        return $this->render($this->template, []);
//    }
}
