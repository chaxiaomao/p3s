<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<table class="table table-bordered mt10">

    <tr>
        <td>料号</td>
        <td>品名</td>
        <td>单位</td>
<!--        <td>件数</td>-->
        <td>数量</td>
<!--        <td>价格</td>-->
<!--        <td>金额</td>-->
        <td>备注</td>
    </tr>

    <?php
    /** @var  $model \common\models\c2\entity\WarehouseNote */
    $noteItems = $model->getNoteItems()->with('measure')->all() ?>

    <?php foreach ($noteItems as $item): ?>
        <tr>
            <td><?= $item->product_sku ?></td>
            <td><?= $item->product_name ?></td>
            <td><?= !is_null($item->measure) ? $item->measure->name : '' ?></td>
            <td><?= $item->number ?></td>
            <td><?= $item->memo ?></td>
        </tr>

    <?php endforeach; ?>

</table>

