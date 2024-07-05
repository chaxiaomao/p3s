<?php


?>

<table class="table table-bordered mt10">

    <tr class="tc">
        <td class="box120">产品编号</td>
        <td class="box120">产品名称</td>
        <td class="box120">产品型号</td>
        <td class="box120">产品库存</td>
        <td class="box120">产品订单总量</td>
        <td class="box120">单位</td>
    </tr>

    <?php use yii\helpers\Html;

    foreach ($data as $datum): ?>
        <tr class="tc">
            <td class=""><?= $datum['product_sku'] ?></td>
            <td class=""><?= $datum['product_name'] ?></td>
            <td class=""><?= $datum['combination_name'] ?></td>
            <td class=""><?= $datum['productCombination']['stock'] ?></td>
            <td class=""><?= $datum['total_sum'] ?></td>
            <td class=""><?= $datum['measure']['name'] ?></td>
        </tr>

    <?php endforeach; ?>

</table>
<?php
echo Html::beginTag('div', ['class' => 'box-footer']);
echo Html::a('<i class="fa fa-window-close-o"></i> ' . Yii::t('app.c2', 'Close'), ['index'], ['data-pjax' => '0', 'data-dismiss' => 'modal', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Close'),]);
echo Html::endTag('div');

?>