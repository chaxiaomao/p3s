<?php

use yii\helpers\Html;
use cza\base\assets\TencentMapAsset;
use cza\base\models\statics\OperationEvent;

TencentMapAsset::register($this);
$theme = $this->theme;
$options = $this->context->options
?>

<?php
echo Html::beginTag('div', $options);
echo Html::tag('iframe', '', $this->context->mapOptions);
echo Html::endTag('div');
?>