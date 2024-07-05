<?php

namespace common\widgets\grid\assets;
use kartik\grid\ActionColumnAsset as kvActionColumnAsset;
use Yii;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActionColumnAsset extends kvActionColumnAsset {

    /**
     * @inheritdoc
     */
    public function init() {
        $this->setSourcePath(Yii::getAlias('@vendor').'/kartik-v/yii2-grid/assets');
        $this->setupAssets('js', ['js/kv-grid-action']);
        $this->setupAssets('css', ['css/kv-grid-action']);
        parent::init();
    }

}
