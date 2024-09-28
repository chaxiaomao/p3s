<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="region-province-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'type',
            'code',
            'label',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

