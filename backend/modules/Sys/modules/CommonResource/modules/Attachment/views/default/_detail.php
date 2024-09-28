<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="entity-attachment-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'entity_id',
            'entity_class',
            'entity_attribute',
            'type',
            'name',
            'label',
            'content:ntext',
            'hash',
            'extension',
            'size',
            'mime_type',
            'logic_path',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

