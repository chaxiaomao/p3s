<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\c2\entity\Order */

$this->title = '销售订单打印';
?>
<div class="order-view">

    <?=  $this->render('_detail', ['model' => $model]); ?>

</div>
