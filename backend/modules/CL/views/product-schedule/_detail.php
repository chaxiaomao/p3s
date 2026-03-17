<?php
?>


<table class="table table-bordered table-hover" style="background-color: #d9edf7;">

    <tr class="tc">
        <!--        <td class="box60">产品编号</td>-->
        <td class="box60">名称</td>
        <td class="box60">标签</td>
        <td class="box60">值</td>
        <td class="box60">备注</td>
        <td class="box60">合单需送料数</td>
        <td class="box60">合单已送料数</td>
        <td class="box60">合单未送料数</td>
        <td class="box60">物料库存数</td>
        <td class="box60">合单后物料总数</td>
        <td class="box60">合单后库存情况</td>
    </tr>

    <?php foreach ($products as $item): ?>
        <?php
        $unit = isset($item['product']['measure']) ? $item['product']['measure']['name'] : '';
        ?>

        <tr>
            <!--            <td class="">--><?php //= $item['need_product_sku'] ?><!--</td>-->
            <td class=""><?= $item['need_product_name'] ?></td>
            <td class=""><?= $item['need_product_label'] ?></td>
            <td class=""><?= $item['need_product_value'] ?></td>
            <td class=""><?= $item['memo'] ?></td>
            <td class=""><?= $need_sum[$item['need_product_id']] ?><?= $unit ?></td>
            <td class=""><?= $send_sum[$item['need_product_id']] ?><?= $unit ?></td>
            <td class=""><?= $need_sum[$item['need_product_id']] - $send_sum[$item['need_product_id']] ?><?= $unit ?></td>
            <td class="">
                <?php
                $num = $item['product']['stock'];
                if ($item['product']['stock'] > 0) {
                    echo "<span class='text-green'>{$num}{$unit}</span>";
                } else {
                    echo "<span class='text-red'>{$num}{$unit}</span>";
                }
                ?>
            </td>
            <!--            <td class="">--><?php //= $send_sum[$item['need_product_id']] ?><!----><?php //= $unit ?><!--</td>-->
            <td class=""><?= $need_sum[$item['need_product_id']] ?><?= $unit ?></td>
            <td class="">
                <?php

                $prod_stock = $item['product']['stock'];

                $need_items = $need_products[$item['need_product_id']];
                $remain_total = 0;
                foreach ($need_items as $need_item) {
                    if ($need_item['send_sum'] < $need_item['need_sum']) {
                        $remain_total += $need_item['need_sum'] - $need_item['send_sum'];
                    }
                }

                $num = $prod_stock - $remain_total;
                if ($num > 0) {
                    echo "<span class='text-green'>{$num}{$unit}</span>";
                } else {
                    echo "<span class='text-red'>{$num}{$unit}</span>";
                }
                ?>
                <a class="btn btn-link" role="button" data-toggle="collapse" href="#Expand_<?= $item['id'] . $item['need_product_id'] ?>"
                   aria-expanded="false"
                   aria-controls="collapseExample">查看
                    <!--                    <span class="badge">-->
                    <!--                        --><?php //= count($need_products[$item['need_product_id']]) ?>
                    <!--                    </span>-->
                </a>
            </td>
        </tr>

        <tr>
            <td class="no-padding" colspan="11">
                <div class="collapse " id="Expand_<?= $item['id'] . $item['need_product_id'] ?>">

                    <table class="table table-bordered margin-bottom-none bg-gray">

                        <tr class="">
                            <td class="box60">订单编号</td>
                            <td class="box60">名称</td>
                            <td class="box60">标签</td>
                            <td class="box60">值</td>
                            <td class="box60">备注</td>
                            <td class="box60">需要物料数量</td>
                            <td class="box60">已送料数</td>
                            <td class="box60">未送料数</td>
                        </tr>

                        <?php foreach ($need_products[$item['need_product_id']] as $item1): ?>
                            <tr class="">
                                <td><?= $item1['code'] ?></td>
                                <td><?= $item1['need_product_name'] ?></td>
                                <td><?= $item1['need_product_label'] ?></td>
                                <td><?= $item1['need_product_value'] ?></td>
                                <td><?= $item1['memo'] ?></td>
                                <td><?= $item1['need_sum'] . $unit ?></td>
                                <td class=""><?= $item1['send_sum'] ?><?= $unit ?></td>
                                <td class=""><?= $item1['need_sum'] - $item1['send_sum'] ?><?= $unit ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                </div>
            </td>

        </tr>

    <?php endforeach; ?>


</table>