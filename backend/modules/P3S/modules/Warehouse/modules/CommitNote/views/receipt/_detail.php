<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="warehouse-commit-note-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'type',
            'note_id',
            'label',
            'product_id',
            'receiver_name',
            'updated_by',
            'created_by',
            'memo:ntext',
            'state',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

