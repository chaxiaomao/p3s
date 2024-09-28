<?php

namespace common\widgets;

use Yii;
use cza\base\widgets\Widget;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;

/**
 *  TencentPoiMarker Widget
 *  refer to http://lbs.qq.com/tool/component-marker.html
 * @author Ben Bi <bennybi@qq.com>
 * @license
 */
class TencentPoiMarker extends Widget {

    public $apiLink = "https://apis.map.qq.com/tools/poimarker?type={type}&marker={marker};&init_view={initview};&key={key}&referer={referer}";
//    public $apiLink = "http://apis.map.qq.com/tools/poimarker?type=0&marker=coord:39.96554,116.26719;title:成都;addr:北京市海淀区复兴路32号院&key={key}&referer={referer}";
    public $type = 0;
    public $key;
    public $center;
    public $marker;
    public $title;
    public $addr;
    public $initview = 1;
    public $referer = 'myapp';
    public $mapOptions = [];

    public function init() {
        $defaultOptions = [
            'id' => 'map-container',
            'class' => 'map',
        ];
        $this->options = ArrayHelper::merge($defaultOptions, $this->options);

        $this->apiLink = strtr($this->apiLink, [
            '{type}' => $this->type,
            '{center}' => $this->center,
            '{marker}' => $this->marker,
            '{title}'=>$this->title,
            '{addr}'=>$this->addr,
            '{key}' => $this->key,
            '{referer}' => $this->referer,
            '{initview}'=> $this->initview,
        ]);
       
        if(!empty($this->coord)){
            $this->apiLink.= "&coord={$this->coord}";
        }
//        Yii::info($this->apiLink);
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
}
