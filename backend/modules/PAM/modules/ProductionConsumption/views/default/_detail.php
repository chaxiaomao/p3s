<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="production-consumption-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'schedule_id',
            'schedule_item_id',
            'need_product_id',
            'need_product_sku',
            'need_product_name',
            'need_product_label',
            'need_product_value',
            'need_number',
            'need_sum',
            'memo',
            'state',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

