<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\c2\entity\OrderItem */
$subtotal = 0;
foreach ($models as $item1) {
    $subtotal += $item1['product_sum'];
}
?>
<div class="order-item-view " ">

    <table class="table table-bordered margin-bottom-none bg-gray">
        <tr class="">
            <td class="" style="max-width: 300px">订单编号</td>
            <td class="">名称</td>
            <td class="">型号</td>
            <td class="">件数</td>
            <td class="">数量</td>
            <td class="">备注</td>
        </tr>
        <?php foreach ($models as $item1): ?>
            <tr class="">
                <td>
                    <p><?= $item1['code'] ?></p>
                    <p><?= '备注：'. $item1['order_memo'] ?></p>
                </td>
                <td><?= $item1['product_name'] ?></td>
                <td><?= $item1['combination_name'] ?></td>
                <td><?= $item1['pieces'] ?></td>
                <td><?= $item1['product_sum'] ?></td>
                <td><?= $item1['memo'] ?></td>
            </tr>
        <?php endforeach; ?>

        <tr>
            <td class="" colspan="4">合计</td>
            <td class=""><?= $subtotal ?></td>
            <td class=""></td>
        </tr>

    </table>

</div>
