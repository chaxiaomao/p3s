<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="order-item-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'order_id',
            'label',
            'customer_id',
            'product_id',
            'product_name',
            'product_sku',
            'product_label',
            'product_value',
            'combination_id',
            'combination_name',
            'package_id',
            'package_name',
            'measure_id',
            'pieces',
            'product_sum',
            'produce_number',
            'price',
            'subtotal',
            'memo',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

