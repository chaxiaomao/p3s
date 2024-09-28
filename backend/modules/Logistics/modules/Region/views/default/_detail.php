<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="region-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'code',
            'label',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

