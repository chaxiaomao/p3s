<?php

use yii\helpers\Html;
use yii\helpers\Url;

$product = $model->items[0] ? $model->items[0] : [];
?>

<style>
    tr {
        height: 30px;
    }
    tr td {
        line-height: 30px !important;
    }
</style>

<?php
$this->title = '排产领料表打印';
?>
<h2 class="tc" style="font-size: 30px;">中山市帕奇家居用品有限公司</h2>
<h2 class="tc" style="font-size: 20px;">ZHONG SHAN PiKi HOUSEWARE (PA QI)Co.,LTD</h2>
<h5 class="tc" style="font-size: 18px;">排产领料表</h5>

<?php if (!empty($product)): ?>
    <table class="table table-bordered mt10 ">
        <tr class="tc" style="background: yellow">
            <td class="" colspan="2"><?= $product->product_sku . $product->product_name  . $product->combination_name . $product->package_name ?></td>
            <td class="">数量：<?= $product->production_sum ?></td>
            <td class="">件数：<?= $product->pieces ?></td>

        </tr>

        <tr class="tc">
            <td style="min-width: 300px">物料名称</td>
            <!--        <td class="box120">标签</td>-->
            <td style="min-width: 200px">规格</td>
            <!--            <td class="box120">使用数量/单位</td>-->
            <!--        <td class="box120">单位</td>-->
            <!--        <td class="box120">当前物料库存</td>-->
            <td style="min-width: 200px">数量</td>
            <td style="min-width: 200px">备注</td>
            <!--        <td class="box120">库存</td>-->
            <!--        <td class="box120">差值</td>-->
        </tr>

        <?php

        foreach ($data as $datum): ?>
            <tr class="tc">
                <td class="success"><?= $datum['need_product_name'] ?></td>
                <!--            <td class="success">--><?//= $datum['need_product_label'] ?><!--</td>-->
                <td class="success"><?= $datum['need_product_value'] ?></td>
                <!--                <td class="success">--><? //= $datum['need_number'] ?><!--</td>-->
                <!--            <td class="success">--><?//= $datum['product']['measure']['name'] ?><!--</td>-->
                <td class="success"><?= $datum['sum'] ?></td>
                <td class="success"><?= $datum['memo'] ?></td>
                <!--            <td class="success">--><?//= $datum['product']['stock'] ?><!--</td>-->
                <!--            <td class="success">--><?//= $datum['product']['stock'] ?><!--</td>-->
                <!--            <td class="success">--><?//= $datum['product']['stock'] - $datum['sum'] ?><!--</td>-->
            </tr>

        <?php endforeach; ?>

        <tr>
            <td colspan="2">排产日期：<?= !empty($model->occurrence_date) ? $model->occurrence_date : date('Y-m-d') ?></td>
            <td>配料员签名：</td>
            <td>领料员签名：</td>
        </tr>

    </table>
<?php endif; ?>
