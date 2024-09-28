<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="currency-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'name',
            'label',
            'iso_code',
            'is_main',
            'convert_rate',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

