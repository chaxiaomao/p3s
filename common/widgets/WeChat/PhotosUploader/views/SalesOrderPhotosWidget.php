<?php

use yii\helpers\Html;

$uiOptions = $this->context->uiOptions;
?>

<div class="page__bd">
    <div class="weui-gallery" id="<?= $uiOptions['galleryId'] ?>">
        <span class="weui-gallery__img" id="<?= $uiOptions['galleryImgId'] ?>"></span>
        <div class="weui-gallery__opr">
            <?php if ($uiOptions['enableUpload']): ?>
            <a href="javascript:" class="weui-gallery__del">
                <i class="weui-icon-delete weui-icon_gallery-delete"></i>
            </a>
            <?php endif ?>
        </div>
    </div>

    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <div class="weui-uploader">
                    <div class="weui-uploader__hd">
                        <p class="weui-uploader__title"><?= $uiOptions['title'] ?></p>
                    </div>
                    <div class="weui-uploader__bd">
                        <ul class="weui-uploader__files" id="<?= $uiOptions['uploaderFilesId'] ?>">
                            <?php
                            foreach ($items as $item) {
                                echo Html::tag('li', '', ['class' => 'weui-uploader__file', 'id' => $item->hash, 'data-hash' => $item->hash, 'style' => "background-image:url(" . $item->getOriginalUrl() . ")"]);
                            }
                            ?>
                        </ul>
                        <?php if ($uiOptions['enableUpload']): ?>
                        <div class="weui-uploader__input-box" id="<?= $uiOptions['uploaderInputId'] ?>">
                            <?php
                            if (!Yii::$app->wechat->isWechat) {
                                echo Html::fileInput('uploaderInput', null, ['class' => "weui-uploader__input", 'accept' => "image/*", "multiple"]);
                            }
                            ?>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



