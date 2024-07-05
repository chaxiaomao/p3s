<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\c2\entity\InventoryReceiptNote */

$this->title = '采购订单打印';
?>
<div class="inventory-receipt-note-view">

    <?=  $this->render('_detail', ['model' => $model]); ?>

</div>
