<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use cza\base\models\statics\OperationEvent;
use cza\base\widgets\ui\adminlte2\InfoBox;
use cza\base\models\statics\EntityModelStatus;
use common\models\c2\statics\ConfigType;
use cza\base\models\statics\ResponseDatum;

$messageName = $model->getMessageName();
?>
<?php Pjax::begin(['id' => $model->getPjaxName(), 'formSelector' => $model->getBaseFormName(true), 'enablePushState' => false]) ?>
<?php
$form = ActiveForm::begin([
            'action' => ['params-save',],
            'options' => [
                'id' => $model->getBaseFormName(),
                'data-pjax' => false,
        ]]);
?>

<div class="<?= $model->getPrefixName('form') ?>">
    <?php if (Yii::$app->session->hasFlash($messageName)): ?>
        <?php
        $flash = Yii::$app->session->getFlash($messageName);
//        Yii::info($flash);
        if (!empty($flash['error'])) {
            unset($flash['error']);
            echo InfoBox::widget([
                'withWrapper' => false,
                'defaultMessageType' => InfoBox::TYPE_WARNING,
                'messages' => $flash,
            ]);
        } else {
            echo InfoBox::widget([
                'withWrapper' => false,
                'messages' => Yii::$app->session->getFlash($messageName),
            ]);
            $success = Yii::t('cza', 'Tips');
            $result = ResponseDatum::getSuccessDatum([
                    'message' => Yii::t('app.c2', 'Operation Success!')
            ]);
            $res = json_encode($result);
            $js = "$.msgGrowl({
                    type: $res._meta.type, 
                    title: '".$success."',
                    text: $res._meta.message,
                    position: 'top-right',
                });";
            $this->registerJs($js);
        }
//        if (!$model->hasErrors()) {
//            echo InfoBox::widget([
//                'withWrapper' => false,
//                'messages' => Yii::$app->session->getFlash($messageName),
//            ]);
//            $success = Yii::t('cza', 'Tips');
//            $result = ResponseDatum::getSuccessDatum([
//                    'message' => Yii::t('app.c2', 'Operation Success!')
//            ]);
//            $res = json_encode($result);
//            $js = "$.msgGrowl({
//                    type: $res._meta.type, 
//                    title: '".$success."',
//                    text: $res._meta.message,
//                    position: 'top-right',
//                });";
//            $this->registerJs($js);
//        } else {
//            Yii::info($model->getMessageName());
//            echo InfoBox::widget([
//                'defaultMessageType' => InfoBox::TYPE_WARNING,
//                'messages' => Yii::$app->session->getFlash($messageName),
//            ]);
//        }
        ?>
    <?php endif; ?>

    
    
    <div class="well">
        <?php
        echo "<div class='panel panel-default'>";
        echo "<div class='panel-heading'>".Yii::t('app.c2', 'EShop Params')."</div>";
        echo "<div class='panel-body'>";
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'generalDistributor' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => \common\models\c2\entity\Distributor::getDistributeHashMap('user_id', 'fullname')],
                'generalShop' =>  ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => \common\models\c2\entity\Shop::getGeneralShopHashMap('id', 'label')],
                'commissionScore' =>  ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('commissionScore')]],
                'orderCommissionPriod' =>  ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('orderCommissionPriod')]],
                'orderAfterSalePeriod' =>  ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('orderAfterSalePeriod')]],
                'bizLevelOneCommission' =>  ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('bizLevelOneCommission')]],
                'bizLevelTwoCommission' =>  ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('bizLevelTwoCommission')]],
                'bizLevelOneShareCommission' =>['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('bizLevelOneShareCommission')]],
                'feUserShareScoreRate' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('feUserShareScoreRate')]],
//                'feUserBuyScoreRate' =>  ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('feUserBuyScoreRate')]],
            ]
        ]);
        
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 3,
            'attributes' => [
                'AutoCloseNoPayOrder' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('AutoCloseNoPayOrder')]],
                'AutoNoSendOrder' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('AutoNoSendOrder')]],
                'AutoSign' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('AutoSign')]],
                'AutoComment' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('AutoComment')]],
                'AutoWaitHandle' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('AutoWaitHandle')]],
                'AutoWaitPrepare' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('AutoWaitPrepare')]],
//                'AutoAccountOfDay' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('AutoAccountOfDay')]],
            ]
        ]);
        
        echo "<div class='panel panel-default'>";
        echo "<div class='panel-heading'>".Yii::t('app.c2', 'Consumtion Group Params')."</div>";
        echo "<div class='panel-body'>";
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 4,
            'attributes' => [
                'productInstallFeePercent' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('productInstallFeePercent')]],
                'groupValidDuration' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('groupValidDuration')]],
                'groupBargainNumber' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('groupBargainNumber')]],
                'groupTeamBuyingNumber' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('groupTeamBuyingNumber')]],
            ]
        ]);
        echo "</div></div>";
        
        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::endTag('div');
        
        
        echo "</div></div>";
        echo "<div class='panel panel-default'>";
        echo "<div class='panel-heading'>".Yii::t('app.c2', 'CRM Params')."</div>";
        echo "<div class='panel-body'>";
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'maxSalesmanNumberPerShop' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('maxSalesmanNumberPerShop')]],
                'salesmanCommission' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('salesmanCommission')]],
                'bizmanagerCommission' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('bizmanagerCommission')]],
            ]
        ]);
        echo "</div></div>";
        echo Html::hiddenInput('modelClass', $model::className(), ['class' => 'modelClass']);
        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::endTag('div');
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

<?php

$js = "";
$js .= "jQuery('{$model->getPjaxName(true)}').off('pjax:send').on('pjax:send', function(){jQuery.fn.czaTools('showLoading', {selector:'{$model->getPjaxName(true)}', 'msg':''});});\n";
$js .= "jQuery('{$model->getPjaxName(true)}').off('pjax:complete').on('pjax:complete', function(){jQuery.fn.czaTools('hideLoading', {selector:'{$model->getPjaxName(true)}'});});\n";
$this->registerJs($js);
?>