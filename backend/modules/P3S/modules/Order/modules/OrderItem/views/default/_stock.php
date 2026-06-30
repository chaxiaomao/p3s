<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\c2\entity\OrderItem */

?>
<div class="order-item-view">

    <table class="table table-bordered " style="background-color: #d9edf7;">

        <tr class="tc">
            <td class="box60">产品编号</td>
            <td class="box60">名称</td>
            <td class="box60">型号</td>
            <td class="box60">包装</td>
            <td class="box60">件数</td>
            <td class="box60">数量</td>
            <td class="box60">备注</td>
            <td class="box60">库存数</td>
            <td class="box60">合单总数</td>
            <td class="box60">库存剩余</td>
        </tr>

        <?php foreach ($models as $item): ?>
            <?php
            $stock = $item['stock'];
            $subtotal = 0;
            foreach ($item['other_order_items'] as $item1) {
                $subtotal += $item1['product_sum'];
            }
            // $diff = $stock - $subtotal
            ?>
            <tr class="tc">
                <td class=""><?= $item['product_sku'] ?></td>
                <td class=""><?= $item['product_name'] ?></td>
                <td class=""><?= $item['combination_name'] ?></td>
                <td class=""><?= $item['package_name'] ?></td>
                <td class=""><?= $item['pieces'] ?></td>
                <td class=""><?= $item['product_sum'] ?></td>
                <td class=""><?= $item['memo'] ?></td>
                <td class=""><?= $item['stock'] ?></td>
                <td class="">
                    <?= $subtotal ?>
                    <a class="btn btn-link" role="button" data-toggle="collapse" href="#Expand_<?= $item['code'] . $item['combination_id'] ?>"
                       aria-expanded="false"
                       aria-controls="collapseExample"
                    >
                       查看
                    </a>
                </td>
                <td class=""><?= $item['stock'] - $subtotal ?></td>
            </tr>

            <tr>
                <td class="no-padding" colspan="11">
                    <div class="collapse " id="Expand_<?= $item['code'] . $item['combination_id'] ?>">
                        <table class="table table-bordered margin-bottom-none bg-gray">
                            <tr class="">
                                <td class="">订单编号</td>
                                <td class="">名称</td>
                                <td class="">型号</td>
                                <td class="">件数</td>
                                <td class="">数量</td>
                                <td class="">备注</td>
                            </tr>
                            <?php foreach ($item['other_order_items'] as $item1): ?>
                                <tr class="">
                                    <td><?= $item1['code'] ?></td>
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
                </td>
            </tr>


        <?php endforeach; ?>
    </table>

</div>
