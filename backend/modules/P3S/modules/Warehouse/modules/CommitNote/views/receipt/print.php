<?php
?>
<h2 class="tc" style="font-size: 30px;">中山市帕奇家居用品有限公司</h2>
<h5 class="tc p20" style="font-size: 18px;">采购订单</h5>

<div class="row pt10">
    <div class="col-xs-3">订单编号：<?= $model->code ?></div>
    <div class="col-xs-3">ISO标号：</div>
    <div class="col-xs-3">订购日期：<?= date('Y-m-d', strtotime($model->occurrence_date)) ?></div>
    <div class="col-xs-3">交货日期：<?= date('Y-m-d', strtotime($model->arrival_date)) ?></div>
</div>
<div class="row pt10">
    <div class="col-xs-3">厂商名称：<?= $model->supplier->name ?></div>
    <div class="col-xs-3">联系人：<?= $model->supplier->contact_name ?></div>
    <div class="col-xs-3">传真：<?= $model->supplier->fax ?></div>
    <div class="col-xs-3">联系电话：<?= $model->supplier->contact_phone ?></div>
</div>

<div class="row pt10">
    <!--    <div class="col-xs-3">订购日期：</div>-->
    <div class="col-xs-3">地址：<?= strip_tags($model->supplier->description) ?></div>
    <div class="col-xs-3">部门：<?= $model->dept_manager_name ?></div>
    <div class="col-xs-3">经手人：<?= $model->financial_name ?></div>
</div>

<table class="table table-bordered mt10">

    <tr class="tc">
        <td class="box120">料号</td>
        <td class="box120">品名</td>
        <td class="box120">数量</td>
        <td class="box120">单位</td>
        <td class="box120">价格</td>
        <td class="box120">金额</td>
        <td class="memo">备注</td>
    </tr>

    <?php foreach ($model->noteItems as $item): ?>
        <tr class="tc">
            <td class=""><?= $item->product_value ?></td>
            <td class=""><?= $item->product_name ?></td>
            <td class=""><?= $item->number ?></td>
            <td class=""><?= !is_null($item->measure) ? $item->measure->name : '' ?></td>
            <td class=""><?= $item->price ?></td>
            <td class=""><?= $item->subtotal ?></td>
            <td class=""><?= $item->memo ?></td>
        </tr>

    <?php endforeach; ?>

</table>

<div class="container-fluid">
    <p>备注：<?= $model->memo ?></p>
</div>
