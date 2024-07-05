<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="inventory-receipt-note-item-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'note_id',
            'product_id',
            'product_name',
            'product_sku',
            'product_label',
            'product_value',
            'measure_id',
            'pieces',
            'price',
            'subtotal',
            'purcharse_order_code',
            'memo',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

