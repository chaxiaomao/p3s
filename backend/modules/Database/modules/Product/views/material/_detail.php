<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="product-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'type',
            'seo_code',
            'sku',
            'name',
            'label',
            'value',
            'low_price',
            'sales_price',
            'cost_price',
            'market_price',
            'supplier_id',
            'currency_id',
            'measure_id',
            'summary:ntext',
            'description:ntext',
            'sold_count',
            'is_released',
            'released_at',
            'created_by',
            'updated_by',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

