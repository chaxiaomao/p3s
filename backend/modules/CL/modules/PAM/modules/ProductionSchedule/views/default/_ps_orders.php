<!--<div class="list-group">-->
<!---->
<!--    --><?php //foreach($orders as $order): ?>
<!--        --><?php
//         $unit = isset($order['product']['measure']) ? $order['product']['measure']['name'] : '';
//         ?>
<!---->
<!--        <p class="list-group-item">-->
<!---->
<!--            订单号：--><?php //= $order['code'] ?><!--<br>-->
<!---->
<!--            生产数：--><?php //= $order['production_sum'] ?><!----><?php //= $unit ?><!--<br>-->
<!---->
<!--            已进仓数：--><?php //= $order['enter_sum'] ?><!----><?php //= $unit ?>
<!---->
<!--        </p>-->
<!---->
<!--    --><?php //endforeach; ?>
<!---->
<!--</div>-->

<table class="table table-bordered ">

    <tr class="tc">
        <td class="box60">订单号</td>
        <td class="box60">标签</td>
        <td class="box60">备注</td>
        <td class="box60">下单日期</td>
        <td class="box60">预计出货日期</td>
        <td class="box60">实际出货日期</td>
        <td class="box60">生产数</td>
        <td class="box60">已进仓数</td>
        <td class="box60">未进仓数</td>
<!--        <td class="box60">库存数</td>-->
    </tr>

    <?php foreach ($orders as $item): ?>
        <?php
        $unit = isset($item['product']['measure']) ? $item['product']['measure']['name'] : '';
        ?>

        <tr>
            <td class=""><?= $item['code'] ?></td>
            <td class=""><?= $item['label'] ?></td>
            <td class=""><?= $item['memo'] ?></td>
            <td class=""><?= $item['occurrence_date'] ?></td>
            <td class=""><?= $item['estimated_ship_date'] ?></td>
            <td class=""><?= $item['actual_ship_date'] ?></td>
            <td class=""><?= $item['production_sum'] ?><?= $unit ?></td>
            <td class=""><?= $item['enter_sum'] ?><?= $unit ?></td>
            <td class=""><?= $item['production_sum'] - $item['enter_sum'] ?><?= $unit ?></td>
<!--            <td class="">--><?php //= $item['product']['stock'] ?><!----><?php //= $unit ?><!--</td>-->
        </tr>

    <?php endforeach; ?>


</table>