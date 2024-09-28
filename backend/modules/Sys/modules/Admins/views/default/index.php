<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\c2\search\BeUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Be Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="be-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app.c2', 'Create Be User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'attributeset_id',
            'login_name',
            'email:email',
            // 'algorithm',
            // 'active_key',
            // 'password_hash',
            // 'auth_key',
            // 'password_reset_token',
            // 'access_token',
            // 'unconfirmed_email:email',
            // 'confirmed_at',
            // 'firstname',
            // 'lastname',
            // 'created_by',
            // 'updated_by',
            // 'last_login_at',
            // 'last_login_ip',
            // 'blocked_at',
            // 'status',
            // 'priority',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
