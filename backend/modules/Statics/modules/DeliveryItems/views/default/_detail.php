<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="inventory-delivery-note-item-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'note_id',
            'customer_id',
            'product_id',
            'product_name',
            'product_sku',
            'package_id',
            'package_name',
            'combination_id',
            'combination_name',
            'measure_id',
            'pieces',
            'product_sum',
            'volume',
            'weight',
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

