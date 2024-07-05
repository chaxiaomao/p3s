<?php
use yii\helpers\Html;
use cza\base\widgets\ui\adminlte2\InfoBox;
use yii\helpers\Url;

$messageName = $model->getMessageName();
?>

<div class="<?= $model->getPrefixName('album-form') ?>">
    <?php if (Yii::$app->session->hasFlash($messageName)): ?>
        <?php
        if (!$model->hasErrors()) {
            echo InfoBox::widget([
                'withWrapper' => false,
                'messages' => Yii::$app->session->getFlash($messageName),
            ]);
        } else {
            echo InfoBox::widget([
                'defaultMessageType' => InfoBox::TYPE_WARNING,
                'messages' => Yii::$app->session->getFlash($messageName),
            ]);
        }
        ?>
    <?php endif; ?>

    <div class="well">
        <?php
        echo \common\widgets\Album\Album::widget([
            'model' => $model,
            'editUrl' => Url::toRoute('/sys/common-resource/attachment/default/edit'),
            'uploadAction' => 'images-upload',
            'deleteAction' => 'images-delete',
            'options' => [
                'id' => $model->getPrefixName('album'),
                'extensions' => implode(',', Yii::$app->params['config']['upload']['imageWhiteExts']),
            ],
            'listOptions' => [
                'itemView' =>  '@app/modules/Database/modules/ProductCombination/views/default/_image_list_item',
            ],
        ]);

        echo Html::beginTag('div', ['class' => 'box-footer']);
        //        echo Html::button('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Test'), ['id' => 'btn-test', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
        echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), ['index'], ['class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
        echo Html::endTag('div');
        ?>
    </div>
</div>

<?php

//$js = "";
//$js .= "$('#btn-test').off('click').on('click', function(event){\n"
////        . "$.pjax.reload({container: '#{$model->getPrefixName('images-list-pjax')}', async: false});"
////        . "$.pjax({url: '" . Url::current() . "',container: '#product-images-list-pjax'});\n"
//        . "$('#{$model->getPrefixName('images-list-pjax')} a.refresh').click();\n"
//        . "});\n";
//$this->registerJs($js);
?>
