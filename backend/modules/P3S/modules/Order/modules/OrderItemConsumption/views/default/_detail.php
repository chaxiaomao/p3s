<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="order-item-consumption-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'order_id',
            'order_item_id',
            'need_product_id',
            'need_product_sku',
            'need_product_name',
            'need_product_label',
            'need_product_value',
            'sale_product_sum',
            'need_number',
            'need_sum',
            'memo',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

