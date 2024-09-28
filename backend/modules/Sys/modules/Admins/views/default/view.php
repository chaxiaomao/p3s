<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\c2\entity\BeUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app.c2', 'Be Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="be-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app.c2', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app.c2', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app.c2', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'attributeset_id',
            'login_name',
            'email:email',
            'algorithm',
            'active_key',
            'password_hash',
            'auth_key',
            'password_reset_token',
            'access_token',
            'unconfirmed_email:email',
            'confirmed_at',
            'firstname',
            'lastname',
            'created_by',
            'updated_by',
            'last_login_at',
            'last_login_ip',
            'blocked_at',
            'status',
            'priority',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
