<?php
$this->title = '送货订单打印';
?>
<h2 class="tc" style="font-size: 30px;">中山市帕奇家居用品有限公司</h2>
<h2 class="tc" style="font-size: 20px;">ZHONG SHAN PiKi HOUSEWARE (PA QI)Co.,LTD</h2>
<h5 class="tc" style="font-size: 18px;">送货订单</h5>


<div class="row">
    <div class="col-xs-3">SO:<?= $model->code ?></div>
    <div class="col-xs-3">电话：<?= $model->warehouse->contact_phone ?></div>
    <div class="col-xs-3">传真：<?= $model->warehouse->fax ?></div>
    <div class="col-xs-3">送货日期：<?= date('Y-m-d', strtotime($model->occurrence_date))?></div>
</div>

<div class="row">
    <div class="col-xs-3">收货单位：<?= $model->label ?></div>
</div>

<table class="table table-bordered">

    <tr class="tc">
        <td class="box120">编号</td>
        <td class="box300">名称/规格</td>
        <td class="box60">包装</td>
        <td class="box60">件数</td>
        <td class="box60">数量</td>
        <td class="box60">单价</td>
        <td class="box120">金额/元</td>
        <td class="memo">备注</td>
    </tr>

    <?php foreach ($model->noteItems as $item): ?>
        <tr class="tc">
            <td class=""><?= $item->product_sku ?></td>
            <td class=""><?= $item->combination_name != '' ? $item->product_name . '(' . $item->combination_name . ')' : $item->product_name ?></td>
            <td class=""><?= !is_null($item->productPackage) ? $item->productPackage->name : '' ?></td>
            <td class=""><?= $item->pieces ?></td>
            <td class=""><?= $item->product_sum ?></td>
            <td class=""><?= $item->price ?></td>
            <td class=""><?= $item->subtotal ?></td>
            <td class=""><?= $item->memo ?></td>
        </tr>

    <?php endforeach; ?>

    <tr class="">
        <td class="" colspan="6">合计金额大写(人民币)：<?= \common\helpers\MoneyHelper::trendNumToChiness($model->grand_total) ?></td>
        <td class="tc"><?= $model->grand_total ?></td>
        <td class=""></td>
    </tr>

</table>

<div class="row pt10">
    <div class="col-xs-6">送货单位：<?= $model->warehouse->name ?></div>
    <div class="col-xs-6">地址：<?= $model->warehouse->address ?></div>
</div>

<div>
    <?= $model->memo ?>
</div>