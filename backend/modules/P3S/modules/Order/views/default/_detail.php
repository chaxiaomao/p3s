<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>

<h2 class="tc" style="font-size: 30px;">中山市帕奇家居用品有限公司</h2>
<h2 class="tc" style="font-size: 20px;">ZHONG SHAN PiKi HOUSEWARE (PA QI)Co.,LTD</h2>
<h5 class="tc" style="font-size: 18px;">销售订单</h5>

<div class="row">
    <div class="col-xs-4">客户：<?= !is_null($model->customer) ? $model->customer->username : '' ?></div>
    <div class="col-xs-4">PO.NO:<?= $model->code ?></div>
    <div class="col-xs-4">排产日期：<?= date('Y-m-d', strtotime($model->production_date)) ?></div>
</div>
<div class="row">
    <div class="col-xs-4">出货日期：<?= date('Y-m-d', strtotime($model->delivery_date)) ?></div>
</div>
<table class="table table-bordered mt10">

    <tr class="tc">
        <td class="box120">产品编号</td>
        <td class="">产品名称</td>
        <td class="">型号</td>
        <td class="box120">包装</td>
        <td class="box120">件数</td>
        <td class="box120">数量</td>
        <td class="box120">单价</td>
<!--        <td class="box120">上次单价</td>-->
        <td class="box120">小计</td>
<!--        <td class="box120">尺码</td>-->
<!--        <td class="box120">毛重</td>-->
<!--        <td class="box120">净重</td>-->
        <td class="memo">备注</td>
    </tr>

    <?php foreach ($model->orderItems as $item): ?>
        <tr class="tc">
            <td class="success"><?= $item->product_sku ?></td>
            <td class="success"><?= $item->product_name ?></td>
            <td class="success"><?= !is_null($item->productCombination) ? $item->productCombination->name : '' ?></td>
            <td class="success"><?= !is_null($item->productPackage) ? $item->productPackage->name : '' ?></td>
            <td class="success"><?= $item->pieces ?></td>
            <td class="success"><?= $item->product_sum ?></td>
            <td class="success"><?= $item->price ?></td>
<!--            <td class="success">--><?//= $item->getLastPrice() ?><!--</td>-->
            <td class="success"><?= $item->subtotal ?></td>
<!--            <td class="success"></td>-->
<!--            <td class="success"></td>-->
<!--            <td class="success"></td>-->
            <td class="success"><?= $item->memo ?></td>
        </tr>

    <?php endforeach; ?>


</table>

<div>
    <?= $model->memo ?>
</div>