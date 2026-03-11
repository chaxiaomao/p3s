<?php

use common\models\c2\entity\ProductionConsumption;
use yii\helpers\Html;
use yii\widgets\DetailView;


?>


<?php

$data = [];
$product_schedules = [];

/** @var $models ProductionConsumption */
if ($models) {
    foreach ($models as $model) {
        $cost_amount = $model['need_sum'];

        if (isset($data[$model['need_product_id']])) {
            $cost_amount = $model['need_sum'] + $data[$model['need_product_id']]['cost_amount'];
        }

        $data[$model['need_product_id']] = [
            'need_product_id' => $model['need_product_id'],
            'need_product_sku' => $model['need_product_sku'],
            'need_product_name' => $model['need_product_name'],
            'need_product_label' => $model['need_product_label'],
            'need_product_value' => $model['need_product_value'],
            'measure' => $model['product']['measure']['name'],
            'cost_amount' => $cost_amount,
            'current_stock' => $model['product']['stock'],
            // 'diff_amount' => '',
        ];

        // $product_schedules[$model['need_product_id']][] = [
        //     'code' => $model['code'],
        //     'label' => $model['label'],
        //     'need_sum' => $model['need_sum'],
        //     'measure' => $model['product']['measure']['name'],
        // ];
        $product_schedules[$model['need_product_id']][] = array_merge($model, [
            'need_sum' => $model['need_sum'],
            'measure' => $model['product']['measure']['name'],
        ]);
    }
}


?>

<div class="order-item-detail">
    <div class="table-responsive" style="background-color: #fff;width: 100%;">

<!--        <table class="table table-bordered table-hover" style="min-width:1400px;table-layout:fixed;">-->
        <table class="table table-bordered table-hover" style="">

            <tr class="">
                <td class="box60">物料编号</td>
                <td class="box60">物料名称</td>
                <td class="box60">标签</td>
                <td class="box60">值</td>
                <!--            <td class="box120">使用数量/单位</td>-->
                <!--            <td class="box120">单位</td>-->
                <!--        <td class="box120">当前物料库存</td>-->
                <td style="width: 112px">需要物料总量</td>
                <td style="width: 112px">现有库存</td>
                <td style="width: 112px">差值</td>
                <td style="width: 200px">关联订单</td>
            </tr>

            <?php

            foreach ($data as $productid => $datum): ?>
                <tr class="success">
                    <td><?= $datum['need_product_sku'] ?></td>
                    <td><?= $datum['need_product_name'] ?></td>
                    <td><?= $datum['need_product_label'] ?></td>
                    <td><?= $datum['need_product_value'] ?></td>
                    <td><?= $datum['cost_amount'] . ' ' . $datum['measure'] ?></td>
                    <td><?= $datum['current_stock'] . ' ' . $datum['measure'] ?></td>
                    <td>
                        <?php

                        if ($datum['current_stock'] < $datum['cost_amount']) {
                            echo "<span class='text-red'>" . ($datum['current_stock'] - $datum['cost_amount']) . $datum['measure'] . "</span>";
                        } else {
                            echo "<span class='text-green'>剩余" . ($datum['current_stock'] - $datum['cost_amount']) . $datum['measure'] . "</span>";
                        }
                        ?>
                    </td>
                    <td>

                        <a class="btn btn-link" role="button" data-toggle="collapse"
                           href="#Expand_<?= $datum['need_product_id'] ?>" aria-expanded="false"
                           aria-controls="collapseExample">
                            查看
                            <span class="badge"><?= count($product_schedules[$datum['need_product_id']]) ?></span></a>

                    </td>
                </tr>
                <tr>
                    <td class="no-padding" colspan="8">
                        <div class="collapse bg-warning" id="Expand_<?= $datum['need_product_id'] ?>">

                            <table class="table table-bordered table-hover">

                                <tr class="warning">
                                    <td class="box60">订单编号</td>
                                    <td class="box60">订单标签</td>
<!--                                    <td class="box60">下单日期</td>-->
<!--                                    <td class="box60">预计出货日期</td>-->
<!--                                    <td class="box60">实际出货日期</td>-->
                                    <td class="box60">流程状态</td>
                                    <td class="box60">备注</td>
                                    <td class="box60">需要物料数量</td>
                                </tr>

                                <?php foreach ($product_schedules[$datum['need_product_id']] as $item): ?>
                                    <tr class="warning">
                                        <td><?= $item['code'] ?></td>
                                        <td><?= $item['label'] ?></td>
<!--                                        <td>--><?php //= $item['occurrence_date'] ? date('Y-m-d', strtotime($item['occurrence_date'])) : '' ?><!--</td>-->
<!--                                        <td>--><?php //= $item['estimated_ship_date'] ? date('Y-m-d', strtotime($item['estimated_ship_date'])) : '' ?><!--</td>-->
<!--                                        <td>--><?php //= $item['actual_ship_date'] ? date('Y-m-d', strtotime($item['actual_ship_date'])) : '' ?><!--</td>-->
                                        <td><?= \common\models\c2\statics\ProductionScheduleState::getLabel($item['state']) ?></td>
                                        <td><?= $item['memo'] ?></td>
                                        <td><?= $item['need_sum'] . $datum['measure'] ?></td>
                                    </tr>
                                    <!--                                <p>-->
                                    <!--                                    <span>订单编号：--><?php //= $item['code'] ?><!--</span><br/>-->
                                    <!--                                    <span>订单标签：--><?php //= $item['label'] ?><!--</span><br/>-->
                                    <!--                                    <span>需要物料数量：--><?php //= $item['need_sum'] . ' ' . $datum['measure'] ?><!--</span>-->
                                    <!--                                </p>-->
                                    <!--                                <hr/>-->
                                <?php endforeach; ?>
                            </table>

                        </div>
                    </td>

                </tr>

            <?php endforeach; ?>


        </table>
        <?php if (!empty($datetime) && empty($data)): ?>
            <div class="alert">如找不到该月份订单数据，可能需操作一次计算物料。
                <a class="text-red" href="/cl/pam/production-schedule">点击</a>
            </div>
        <?php endif; ?>
    </div>

</div>

