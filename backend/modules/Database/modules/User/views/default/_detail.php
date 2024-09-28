<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="fe-user-model-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'type',
            'attributeset_id',
            'username',
            'email:email',
            'password_hash',
            'auth_key',
            'confirmed_at',
            'unconfirmed_email:email',
            'blocked_at',
            'registration_ip',
            'registration_src_type',
            'flags',
            'level',
            'last_login_at',
            'last_login_ip',
            'open_id',
            'wechat_union_id',
            'wechat_open_id',
            'mobile_number',
            'sms_receipt',
            'access_token',
            'password_reset_token',
            'district_id',
            'province_id',
            'city_id',
            'created_by',
            'updated_by',
            'status',
            'position',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

