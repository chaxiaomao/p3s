<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 15:54
 */
use yii\helpers\Html;
use cza\base\assets\TencentMapAsset;
use cza\base\models\statics\OperationEvent;

TencentMapAsset::register($this);
$this->title = Yii::t('app.c2','导航');
$theme = $this->theme;
$options = $this->context->options
?>

<?php
echo Html::beginTag('div', $options);
echo Html::tag('iframe', '', $this->context->mapOptions);
echo Html::endTag('div');
?>
