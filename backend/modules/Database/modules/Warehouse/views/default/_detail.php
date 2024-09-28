<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="warehouse-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'label',
            'name',
            'code',
            'contact_name',
            'contact_phone',
            'fax',
            'eshop_id',
            'entity_id',
            'entity_class',
            'country_id',
            'province_id',
            'city_id',
            'district_id',
            'area_id',
            'address',
            'geo_longitude',
            'geo_latitude',
            'geo_marker_color',
            'state',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

