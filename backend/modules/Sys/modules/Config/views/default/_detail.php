<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="config-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'type',
            'code',
            'label',
            'default_value:ntext',
            'custom_value:ntext',
            'memo:ntext',
            'created_by',
            'updated_by',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

