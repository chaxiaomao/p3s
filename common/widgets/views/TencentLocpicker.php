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

<?php
$js = "";

$js.="
        window.addEventListener('message', function(event) {
            var loc = event.data;
            if (loc && loc.module == 'locationPicker') {
              $('#{$options['id']}').trigger('" . OperationEvent::COORDINATE_CHANGE . "', loc);
//              console.log('locationPicker', loc);  
            }                                
        }, false); 
    ";
$js.="\n";

$this->registerJs($js);
?>
