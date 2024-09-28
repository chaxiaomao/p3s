<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="product-package-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'product_id',
            'name',
            'label',
            'product_valume',
            'gross_weight',
            'net_weight',
            'memo:ntext',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

