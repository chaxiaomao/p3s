<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/19
 * Time: 8:46
 */

namespace common\widgets\logisticsInformation;
use common\helpers\KdniaoHelper;
use cza\base\widgets\Widget;


class LogisticsInformation extends Widget
{
    public $model = null;
    public $dataProvider = null;

    public function init()
    {
        parent::init();
        if(empty($this->model)){
            throw new \yii\base\Exception('model parameter is required!');
        }
    }

    public function run()
    {

        $Logistics = $this->model->salesOrderExpress;
        $track = new KdniaoHelper();
        if (empty($Logistics)){
            return $this->render($this->template,['message'=>null,'model'=>$this->model]);
        }
        $message =  $track->getOrderTracesByJson($Logistics->code,$Logistics->postal_code);
        $LocationMass = \yii\helpers\Json::decode($message);
        return $this->render($this->template,['message'=>$LocationMass['Traces'],'model'=>$this->model]);
    }

}