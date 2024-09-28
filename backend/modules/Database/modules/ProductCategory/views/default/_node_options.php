<?php ?>
<h4><?= Yii::t('app.c2', 'Admin Settings') ?></h4>
<div class="row">
    <div class="col-sm-4">
        <?= $form->field($node, 'active')->checkbox() ?>
        <?= $form->field($node, 'selected')->checkbox() ?>
        <?= $form->field($node, 'collapsed')->checkbox($flagOptions) ?>
        <?= $form->field($node, 'visible')->checkbox() ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($node, 'readonly')->checkbox() ?>
        <?= $form->field($node, 'disabled')->checkbox() ?>
        <?= $form->field($node, 'removable')->checkbox() ?>
        <?= $form->field($node, 'removable_all')->checkbox($flagOptions) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($node, 'movable_u')->checkbox() ?>
        <?= $form->field($node, 'movable_d')->checkbox() ?>
        <?= $form->field($node, 'movable_l')->checkbox() ?>
        <?= $form->field($node, 'movable_r')->checkbox() ?>
    </div>
</div>