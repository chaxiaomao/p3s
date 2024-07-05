<?php

use common\models\c2\statics\WarehouseNoteItemStatus;
?>


<div style="background-color: #d0e9c6;margin-bottom: 20px;">
    <?= $this->render('print', ['model' => $note]) ?>
</div>
<table class="table table-bordered mt10">

    <tr class="tc">
        <td class="box120">料号</td>
        <td class="box200">品名</td>
        <td class="box200">标签</td>
        <td class="box200">值</td>
        <td class="box60">数量</td>
        <td class="memo">备注</td>
        <td class="memo">状态</td>
    </tr>

    <p style="color: red;">出仓细项（核对数量和状态再确认完成订单，暂停即为未确定进仓）：</p>

    <?php if ($noteItems): ?>

        <?php foreach ($noteItems as $item): ?>
            <tr class="tc">
                <td class=""><?= $item->product_sku ?></td>
                <td class=""><?= $item->product_name ?></td>
                <td class=""><?= $item->product_label ?></td>
                <td class=""><?= $item->product_value ?></td>
                <td class=""><?= $item->number ?></td>
                <td class=""><?= $item->memo ?></td>
                <td class=""><?= WarehouseNoteItemStatus::getLabel($item->status) ?></td>
            </tr>

        <?php endforeach; ?>
    <?php endif; ?>

</table>