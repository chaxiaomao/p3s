<?php
/**
 * Created by xun at 2020/9/22
 */

/** @var $model \common\models\c2\entity\Product */

$ids = \common\models\c2\entity\ProductCombination::find()
    ->select('id')
    ->where(['product_id' => $model->id])
    ->asArray()
    ->all();
$urls = [];
foreach ($ids as $id) {
    $files = \common\models\c2\entity\EntityAttachmentImage::find()
        ->where(['entity_id' => $id, 'entity_class' => \common\models\c2\entity\ProductCombination::className()])->all();
    foreach ($files as $file) {
        $urls[] = $file->getFilelUrl();
    }
}
?>
<?php if (empty($urls)): ?>
    <p>暂无图片</p>
<?php else:?>
    <?php foreach ($urls as $url): ?>

        <?php echo \yii\helpers\Html::img($url, ['style' => ['width' => '100%']]) ?>

    <?php endforeach; ?>
<?php endif; ?>

