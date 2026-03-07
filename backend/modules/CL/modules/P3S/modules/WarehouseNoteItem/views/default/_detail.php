<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="warehouse-note-item-detail">

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
            'combination_id',
            'combination_name',
            'package_id',
            'package_name',
            'pieces',
            'number',
            'memo',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

