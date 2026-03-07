<?php

use common\models\c2\entity\ProductionConsumption;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $y = date('Y', time()) ?>

<!--<nav class="alert" style="background-color: #d1c5d8">-->
<nav class="alert" style="background-color: #899fc1">
    <div class="container-fluid">


        <form class="" method="get">
            <fieldset>
                <div class="row">
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label for="datetime"><?= $y ?>年</label>
                            <select id="datetime" name="datetime" class="form-control">
                                <option></option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <?php $v = $y . '-' . ($i < 10 ? '0' . $i : $i) ?>
                                    <option value="<?= $v ?>" <?= $v == $datetime ? 'selected' : '' ?>>
                                        <?= $i ?>月
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-success">查&nbsp;&nbsp;看</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</nav>

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

        $product_schedules[$model['need_product_id']][] = [
            'code' => $model['code'],
            'label' => $model['label'],
            'need_sum' => $model['need_sum'],
            'measure' => $model['product']['measure']['name'],
        ];
    }
}


?>

<div class="table-responsive" style="background-color: #fff;">

    <table class="table table-bordered table-hover">

        <tr class="tc">
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
            <td style="width: 220px">关联订单</td>
        </tr>

        <?php

        foreach ($data as $productid => $datum): ?>
            <tr class="tc">
                <td class="success"><?= $datum['need_product_sku'] ?></td>
                <td class="success"><?= $datum['need_product_name'] ?></td>
                <td class="success"><?= $datum['need_product_label'] ?></td>
                <td class="success"><?= $datum['need_product_value'] ?></td>
                <!--                <td class="success">--><? //= $datum['need_number'] ?><!--</td>-->
                <!--                <td class="success">--><?php //= $datum['product']['measure']['name'] ?><!--</td>-->
                <td class="success"><?= $datum['cost_amount'] . ' ' . $datum['measure'] ?></td>
                <!--            <td class="success">--><? //= $datum['product']['stock'] ?><!--</td>-->
                <td class="success"><?= $datum['current_stock'] . ' ' . $datum['measure'] ?></td>
                <!--                <td class="success">-->
                <?php //= $datum['product']['stock'] - $datum['cost_amount'] ?><!--</td>-->
                <td class="success">
                    <?php

                    if ($datum['current_stock'] < $datum['cost_amount']) {
                        echo "<span class='text-red'>" . ($datum['current_stock'] - $datum['cost_amount']) . $datum['measure'] . "</span>";
                    }
                    echo '';
                    ?>
                </td>
                <td class="success">

                    <a role="button" data-toggle="collapse" href="#Expand_<?= $datum['need_product_id'] ?>" aria-expanded="false"
                       aria-controls="collapseExample">
                        <i class="glyphicon glyphicon-eye-open">查看</i>
                    </a>
                    <div class="collapse" id="Expand_<?= $datum['need_product_id'] ?>">
                        <?php foreach ($product_schedules[$datum['need_product_id']] as $item): ?>
                            <p style="background-color: #d1c5d8;margin-bottom: 10px;padding: 10px;">
                                订单编号：<?= $item['code'] ?><br/>
                                订单标签：<?= $item['label'] ?><br/>
                                需要物料数量：<?= $item['need_sum'] . ' ' . $datum['measure'] ?>
                            </p>
<!--                        <hr/>-->
                        <?php endforeach; ?>
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


<?php


echo Html::beginTag('div', ['class' => 'box-footer']);
echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), '/pam/production-schedule', ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
echo Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::current(), [
    'class' => 'btn btn-default pull-right',
    'title' => Yii::t('app.c2', 'Reset Grid')
]);
// echo Html::a('<i class="fa fa-window-close-o"></i> ' . Yii::t('app.c2', 'Close'), ['index'], ['data-pjax' => '0', 'data-dismiss' => 'modal', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Close'),]);
echo Html::endTag('div');


?>

<?php


?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
