<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="product-combination-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'product_id',
            'name',
            'label',
            'memo:ntext',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

