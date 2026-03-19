<style>
    .modal-dialog {
        margin: 10% auto;
    }
</style>
<table class="table table-bordered " style="background-color: #d9edf7;">

    <tr class="tc">
        <td class="box60">产品编号</td>
        <td class="box60">名称</td>
        <td class="box60">型号</td>
        <td class="box60">备注</td>
        <td class="box60">生产数量</td>
        <td class="box60">已进仓数</td>
        <td class="box60">未进仓数</td>
        <td class="box60">产品库存</td>
        <!--        <td class="box60">剩余情况</td>-->
        <td class="box60">合单后总数</td>
<!--        <td class="box60">合单后库存差值</td>-->
        <td class="box60">物料情况</td>
    </tr>

    <?php foreach ($models as $item): ?>
        <?php
        $unit = isset($item['product']['measure']) ? $item['product']['measure']['name'] : '';
        $remaining_sum = $item['production_sum'] - $item['enter_sum'];
        ?>
        <tr class="tc">
            <td class=""><?= $item['product_sku'] ?></td>
            <td class=""><?= $item['product_name'] ?></td>
            <td class=""><?= $item['combination_name'] ?></td>
            <td class=""><?= $item['memo'] ?></td>
            <td class=""><span class=""><?= $item['production_sum'] ?><?= $unit ?></span></td>
            <td class=""><span class=""><?= $item['enter_sum'] ?><?= $unit ?></span></td>
            <td class=""><span class=""><?= $remaining_sum ?><?= $unit ?></span></td>
            <td class=""><span class=""><?= $product_stock[$item['combination_id']] ?><?= $unit ?></span></td>
            <td class="">
                <?= $production_sum[$item['combination_id']] ?><?= $unit ?>
                <a role="button"
                   class="view-orders"
                   data-items="<?= getIds($ps_items[$item['combination_id']]) ?>"
                   data-product-name="<?= $item['product_name'] . '(' . $item['combination_name'] . ')' ?>"
                >
                    查看
                </a>
            </td>
<!--            <td class="">-->
<!--                --><?php
//                 // $prod_stock = $product_stock[$item['combination_id']];
//                 // $remain_total = 0;
//                 // foreach ($ps_items[$item['combination_id']] as $ps_item) {
//                 //     if ($ps_item['enter_sum'] < $ps_item['production_sum']) {
//                 //         $remain_total += $ps_item['production_sum'] - $ps_item['enter_sum'];
//                 //     }
//                 // }
//                 // $num = $prod_stock - $remain_total;
//
//                 $num = $product_stock[$item['combination_id']] - $production_sum[$item['combination_id']];
//                 if ($num > 0) {
//                     echo "<span class='text-orange'>{$num}{$unit}</span>";
//                 } else {
//                     echo "<span class='text-red'>{$num}{$unit}</span>";
//                 }
//                 ?>
<!--                <a role="button" data-toggle="collapse" href="#Expand_--><?php //= $item['id'] . $item['combination_id'] ?><!--"-->
<!--                   aria-expanded="false"-->
<!--                   aria-controls="collapseExample">查看-->
<!--<!--                    <span class="badge">-->-->
<!--<!--                        -->--><?php ////= count($ps_items[$item['combination_id']]) ?>
<!--<!--                    </span>-->-->
<!--                </a>-->
<!--            </td>-->

            <td>

                <a role="button"
                   class="view-matters "
                   data-items="<?= getIds($ps_items[$item['combination_id']]) ?>"
                   data-psitemid="<?= $item['id'] ?>"
                   data-psid="<?= $ps_id ?>"
                   data-product-name="<?= $item['product_name'] . '(' . $item['combination_name'] . ')' ?>"
                >
                    查看
                </a>
            </td>
        </tr>

        <tr>
            <td class="no-padding" colspan="11">
                <div class="collapse " id="Expand_<?= $item['id'] . $item['combination_id'] ?>">

                    <table class="table table-bordered margin-bottom-none bg-gray">

                        <tr class="">
                            <td class="box60">订单编号</td>
                            <td class="box60">名称</td>
                            <td class="box60">型号</td>
                            <td class="box60">生产数量</td>
                            <td class="box60">已进仓数</td>
                            <td class="box60">未进仓数</td>
                        </tr>

                        <?php foreach ($ps_items[$item['combination_id']] as $item1): ?>
                            <?php
                            $remaining_sum = $item1['production_sum'] - $item1['enter_sum'];
                            ?>
                            <tr class="">
                                <td><?= $item1['code'] ?></td>
                                <td><?= $item1['product_name'] ?></td>
                                <td><?= $item1['combination_name'] ?></td>
                                <td><span class=""><?= $item1['production_sum'] ?><?= $unit ?></span></td>
                                <td><span class=""><?= $item1['enter_sum'] ?><?= $unit ?></span></td>
                                <td><span class=""><?= $remaining_sum ?><?= $unit ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                </div>
            </td>

        </tr>

    <?php endforeach; ?>

</table>
<?php
function getIds($data)
{
    $arr = [];
    foreach ($data as $datum) {
        $arr[] = $datum['id'];
    }
    return implode(',', $arr);
}

?>
<!-- Modal -->
<div class="modal fade" id="orderModal"
     data-backdrop="static"
     data-keyboard="false"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">订单详情</h4>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <span class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    加载中...
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(function () {
        // Your jQuery and JavaScript code goes here
        jQuery(document).off('click', 'a.view-orders').on('click', 'a.view-orders', function (e) {
            e.preventDefault();

            let ids = $(this).data("items");
            let product_name = $(this).data("product-name");

            $("#orderModal").modal("show");

            $("#orderModal .modal-body").html(
                '<div class="text-center">加载中...</div>'
            );

            $.get("/cl/pam/production-schedule/default/ps-orders", {
                ids: ids
            }, function (res) {
                $("#orderModal .modal-title").text(product_name + " 订单");
                $("#orderModal .modal-body").html(res);
            });
        });
        jQuery(document).off('click', 'a.view-matters').on('click', 'a.view-matters', function (e) {
            e.preventDefault();

            let ids = $(this).data("items");
            let product_name = $(this).data("product-name");
            let psitemid = $(this).data("psitemid");
            let psid = $(this).data("psid");


            $("#orderModal").modal("show");

            $("#orderModal .modal-body").html(
                '<div class="text-center">加载中...</div>'
            );

            $.get("/cl/pam/production-schedule/default/ps-matters", {
                psid: psid,
                psitemid: psitemid,
                ids: ids,
            }, function (res) {
                $("#orderModal .modal-title").text(product_name + " 订单");
                $("#orderModal .modal-body").html(res);
            });
        });
    });
</script>
