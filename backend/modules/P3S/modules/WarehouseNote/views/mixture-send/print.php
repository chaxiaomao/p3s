<?php

?>


<div style="background-color: #f3c17d; margin-bottom: 10px">
    <div class="row">
        <div class="col-xs-3">生产编号：<?= $model->code ?></div>
        <div class="col-xs-3">
            生产类型：<?= \common\models\c2\statics\ProductionScheduleType::getLabel($model->type) ?></div>
        <div class="col-xs-3">标签：<?= $model->label ?></div>
        <div class="col-xs-3">发生日期：<?= date('Y-m-d', strtotime($model->occurrence_date)) ?></div>
        <div class="col-xs-3">完成日期：<?= date('Y-m-d', strtotime($model->financial_name)) ?></div>
    </div>

    <table class="table table-bordered mt10">

        <tr class="tc">
            <td class="box120">产品编号</td>
            <td class="box120">名称</td>
            <td class="box120">型号</td>
            <td class="box120">生产数量</td>
            <td class="box120">进仓数量</td>
            <td class="box120">单位</td>
            <td class="memo">备注</td>
        </tr>

        <?php foreach ($model->scheduleItems as $item): ?>
            <tr class="tc">
                <td class=""><?= $item->product_sku ?></td>
                <td class=""><?= $item->product_name ?></td>
                <td class=""><?= $item->combination_name ?></td>
                <td class=""><?= $item->production_sum ?></td>
                <td class=""><?= $item->enter_sum ?></td>
                <td class=""><?= !is_null($item->product->measure) ? $item->product->measure->name : '' ?></td>
                <td class=""><?= $item->memo ?></td>
            </tr>

        <?php endforeach; ?>

    </table>

    <div class="container-fluid">
        <p>备注：<?= $model->memo ?></p>
    </div>
</div>


<div style="background-color: #d0e9c6; margin-bottom: 10px">

    <table class="table table-bordered mt10">

        <tr class="tc">
            <td class="box120">物料编号</td>
            <td class="box120">名称</td>
            <td class="box120">标签</td>
            <td class="box120">值</td>
            <td class="box120">总需要数量</td>
            <td class="box120">总送料数量</td>
            <td class="box120">仓库数量</td>
            <td class="memo">备注</td>
        </tr>

        <?php foreach ($model->scheduleItemConsumption as $item): ?>
            <tr class="tc">
                <td class=""><?= $item->need_product_sku ?></td>
                <td class=""><?= $item->need_product_name ?></td>
                <td class=""><?= $item->need_product_label ?></td>
                <td class=""><?= $item->need_product_value ?></td>
                <td class=""><?= $item->need_sum ?></td>
                <td class=""><?= $item->send_sum ?></td>
                <td class=""><?= $item->product->stock ?></td>
                <td class=""><?= $item->memo ?></td>
            </tr>

        <?php endforeach; ?>

    </table>

    <div class="container-fluid">
        <p>备注：<?= $model->memo ?></p>
    </div>
</div>
