<?php

use yii\helpers\Html;
use kartik\builder\Form;
use cza\base\models\statics\EntityModelStatus;

$regularLangName = \Yii::$app->czaHelper->getRegularLangName();
?>

<div class="row">
    <div class="col-sm-12">
        <?= Html::activeHiddenInput($node, $keyAttribute); ?>
        <?= Html::activeHiddenInput($node, $iconTypeAttribute) ?>
        <div class="kv-avatar center-block text-center" style="width:230px">
            <?php
            echo Form::widget([
                'model' => $node,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'avatar' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\FileInput',
                        'options' => [
                            'options' => [
                                'accept' => 'image/*',
                            ],
                            'pluginOptions' => [
                                'overwriteInitial' => true,
                                'maxFileSize' => 1500,
                                'showClose' => false,
                                'showCaption' => false,
                                'browseLabel' => '',
                                'removeLabel' => '',
                                'browseIcon' => '<i class="glyphicon glyphicon-folder-open"></i>',
                                'removeIcon' => '<i class="glyphicon glyphicon-remove"></i>',
                                'removeTitle' => 'Cancel or reset changes',
                                'elErrorContainer' => '#kv-avatar-errors-1',
                                'msgErrorClass' => 'alert alert-block alert-danger',
                                'defaultPreviewContent' => '<img src="/images/common/default_img.png" alt="' . Yii::t('app.c2', '{s1} avatar', ['s1' => Yii::t('app.c2', 'Categories')]) . '" style="width:160px">',
                                'layoutTemplates' => "{main2: '{preview} {browse} {remove}'}",
                                'allowedFileExtensions' => ["jpg", "png", "gif"],
                                'showUpload' => false,
                                'initialPreview' => $node->getInitialPreview('avatar', \cza\base\models\statics\ImageSize::ORGINAL),
                                'initialPreviewConfig' => $node->getInitialPreviewConfig('avatar'),
                            ],
                        ],
                    ],
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <?php
        echo Form::widget([
            'model' => $node,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'code' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $node->getAttributeLabel('code')]],
                'name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $node->getAttributeLabel('name')]],
                'label' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $node->getAttributeLabel('label')]],
            ]
        ]);
        ?>
    </div>
    <div class="col-sm-6">
        <?=
        $form->field($node, $iconAttribute)->multiselect($iconsList, [
            'item' => function ($index, $label, $name, $checked, $value) use ($inputOpts) {
                if ($index == 0 && $value == '') {
                    $checked = true;
                    $value = '';
                }
                return '<div class="radio">' . Html::radio($name, $checked, [
                            'value' => $value,
                            'label' => $label,
                            'disabled' => !empty($inputOpts['readonly']) || !empty($inputOpts['disabled'])
                        ]) . '</div>';
            },
            'selector' => 'radio',
        ])
        ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?php
        echo Form::widget([
            'model' => $node,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'description' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\vova07\imperavi\Widget', 'options' => [
                        'settings' => [
                            'minHeight' => 150,
                            'buttonSource' => true,
                            'lang' => $regularLangName,
                            'plugins' => [
                                'fontsize',
                                'fontfamily',
                                'fontcolor',
                                'table',
                                'textdirection',
                                'fullscreen',
                            ],
                        ]
                    ],],
                'status' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => EntityModelStatus::getHashMap('id', 'label')],
                'position' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\touchspin\TouchSpin', 'options' => [
                        'pluginOptions' => [
                            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                        ],
                    ],],
            ]
        ]);
        ?>
    </div>
</div>

