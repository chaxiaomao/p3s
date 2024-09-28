<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="measure-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'code',
            'name',
            'label',
            'description:ntext',
            'is_default',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

