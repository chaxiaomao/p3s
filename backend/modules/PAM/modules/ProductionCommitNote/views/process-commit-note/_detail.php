
<?php
?>

<table class="table table-bordered mt10">

    <tr class="tc">
        <td class="box120">物料编号</td>
        <td class="box120">名称</td>
        <!--        <td class="box120">标签</td>-->
        <!--        <td class="box120">值</td>-->
        <td class="box120">单位</td>
        <td class="box120">进仓数量</td>
        <td class="memo">备注</td>
    </tr>

    <?php foreach ($model->noteItems as $item): ?>
        <tr class="tc">
            <td class=""><?= $item->product_sku ?></td>
            <td class=""><?= $item->product_name . '(' .$item->product_label . ')' . $item->product_value ?></td>
            <td class=""><?= !is_null($item->measure) ? $item->measure->name : '' ?></td>
            <td class=""><?= $item->commit_sum ?></td>
            <td class=""><?= $item->memo ?></td>
        </tr>

    <?php endforeach; ?>

</table>

<div class="container-fluid">
    <p>备注：<?= $model->memo ?></p>
</div>
