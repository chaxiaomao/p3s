<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="supplier-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'code',
            'name',
            'label',
            'contact_name',
            'contact_phone',
            'fax',
            'province_id',
            'city_id',
            'district_id',
            'geo_longitude',
            'geo_latitude',
            'geo_marker_color',
            'description:ntext',
            'is_default',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

