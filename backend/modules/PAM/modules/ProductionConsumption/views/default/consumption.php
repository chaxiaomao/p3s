<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<table class="table table-bordered mt10">

    <tr class="tc">
        <td class="box120">物料编号</td>
        <td class="box120">物料名称</td>
        <td class="box120">标签</td>
        <td class="box120">值</td>
        <!--            <td class="box120">使用数量/单位</td>-->
        <td class="box120">单位</td>
<!--        <td class="box120">当前物料库存</td>-->
        <td class="box120">需要物料数量</td>
        <td class="box120">已送物料数量</td>
        <td class="box120">送发物料</td>
    </tr>

    <?php

    foreach ($data as $datum): ?>
        <tr class="tc">
            <td class="success"><?= $datum['need_product_sku'] ?></td>
            <td class="success"><?= $datum['need_product_name'] ?></td>
            <td class="success"><?= $datum['need_product_label'] ?></td>
            <td class="success"><?= $datum['need_product_value'] ?></td>
            <!--                <td class="success">--><? //= $datum['need_number'] ?><!--</td>-->
            <td class="success"><?= $datum['product']['measure']['name'] ?></td>
            <td class="success"><?= $datum['sum'] ?></td>
<!--            <td class="success">--><?//= $datum['product']['stock'] ?><!--</td>-->
            <td class="success"><?= $datum['send_sum'] ?></td>
            <td class="success"><?= Html::a(Yii::t('app.c2', 'Send Mixture'), [
                    'send-mixture',
                    'id' => $datum['id'],
                    'product_id' => $datum['need_product_id'],
                ], ['class' => 'btn btn-success btn-xs send']) ?></td>
        </tr>

    <?php endforeach; ?>


</table>

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
\yii\bootstrap\Modal::begin([
    'id' => 'send-edit',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false
    ],
]);

$js .= "jQuery(document).off('click', 'a.send').on('click', 'a.send', function(e) {
            e.preventDefault();
            jQuery('#send-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";


$this->registerJs($js);


?>
