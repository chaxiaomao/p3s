<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="inventory-delivery-note-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'type',
            'code',
            'label',
            'warehouse_id',
            'sales_order_id',
            'customer_id',
            'occurrence_date',
            'grand_total',
            'contact_man',
            'cs_name',
            'sender_name',
            'financial_name',
            'payment_method',
            'delivery_method',
            'memo:ntext',
            'remote_ip',
            'is_audited',
            'audited_by',
            'updated_by',
            'created_by',
            'state',
            'status',
            'position',
            'updated_at',
            'created_at',
    ],
    ]) ?>

</div>

