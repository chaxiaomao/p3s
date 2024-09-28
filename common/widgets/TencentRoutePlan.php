<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 15:24
 */

namespace common\widgets;

use Yii;
use cza\base\widgets\Widget;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;

class TencentRoutePlan extends Widget {

    public $apiLink = "https://apis.map.qq.com/tools/routeplan/eword={eword}&epointx={epointx}&epointy={epointy}?referer={referer}&key={key}";
//    public $apiLink = "http://apis.map.qq.com/tools/poimarker?type=0&marker=coord:39.96554,116.26719;title:成都;addr:北京市海淀区复兴路32号院&key={key}&referer
    public $eword;
    public $epointx;
    public $epointy;
    public $referer= 'myapp';
    public $sword;
    public $spointx;
    public $spointy;
    public $footdetail = '1';
    public $topbar = '0';
    public $transport = '1';
    public $editstartbutton = '1';
    public $positionbutton='1';
    public $zoombutton='1';
    public $coordtype='5';
    public $key;
    public $mapOptions = [];

    public function init()
    {
        $defaultOptions = [
            'id' => 'map-container',
            'class' => 'map',
        ];
        $this->options = ArrayHelper::merge($defaultOptions, $this->options);
        $this->apiLink = strtr($this->apiLink,[
            '{eword}'=>$this->eword,
            '{epointx}'=>$this->epointx,
            '{epointy}'=>$this->epointy,
            '{referer}'=>$this->referer,
            '{key}'=>$this->key,
            ]);

        if(!empty($this->spointx)){
            $this->apiLink.= "&spointx={$this->spointx}";
        }
        if(!empty($this->spointy)){
            $this->apiLink.= "&spointy={$this->spointy}";
        }

        $defaultOptions = [
            'id' => 'map-page',
            'width' => '100%',
            'height' => '550px',
            'frameborder' => '0',
            'src' =>$this->apiLink,
        ];
        $this->mapOptions = ArrayHelper::merge($defaultOptions, $this->mapOptions);
        parent::init();
    }
}