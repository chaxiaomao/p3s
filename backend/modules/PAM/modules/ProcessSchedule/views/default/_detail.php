<?php
$this->title = '采购订单打印';
?>

<div class="row">
    <div class="col-xs-3">生产编号：<?= $model->code ?></div>
    <div class="col-xs-3">生产类型：<?= \common\models\c2\statics\ProductionScheduleType::getLabel($model->type) ?></div>
    <div class="col-xs-3">标签：<?= $model->label ?></div>
    <div class="col-xs-3">发生日期：<?= date('Y-m-d', strtotime($model->occurrence_date)) ?></div>
    <div class="col-xs-3">完成日期：<?= date('Y-m-d', strtotime($model->financial_name)) ?></div>
</div>

<table class="table table-bordered mt10">

    <tr class="tc">
        <td class="box120">物料编号</td>
        <td class="box120">名称</td>
        <!--        <td class="box120">标签</td>-->
        <!--        <td class="box120">值</td>-->
        <td class="box120">发出半成品数量</td>
        <td class="box120">单位</td>
        <td class="box120">进仓资料</td>
        <td class="box120">收到成品数量</td>
        <td class="memo">备注</td>
    </tr>

    <?php foreach ($model->scheduleItems as $item): ?>
        <tr class="tc">
            <?php
            $product = $item->enterProduct;
            ?>
            <td class=""><?= $item->product_sku ?></td>
            <td class=""><?= $item->product_name . '(' . $item->product_label . ')' . $item->product_value ?></td>
            <td class=""><?= $item->production_sum ?></td>
            <td class=""><?= !is_null($item->measure) ? $item->measure->name : '' ?></td>
            <td class=""><?= !is_null($product) ? $product->name . '(' . $product->label . ')' . $product->value : '' ?></td>
            <td class=""><?= $item->enter_sum ?></td>
            <td class=""><?= $item->memo ?></td>
        </tr>

    <?php endforeach; ?>

</table>

<div class="container-fluid">
    <p>备注：<?= $model->memo ?></p>
</div>
