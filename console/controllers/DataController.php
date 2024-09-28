<?php

/**
 * Created by PhpStorm.
 * User: chenangel
 * Date: 2017/8/2
 * Time: 上午9:57
 */

namespace console\controllers;


use common\models\c2\entity\Product;
use common\models\c2\statics\ProductType;
use cza\base\models\statics\EntityModelStatus;
use yii\console\Controller;

class DataController extends Controller {


    public function actionProductStock()
    {
        $models = Product::find()->where(['type' => ProductType::TYPE_PRODUCT])->all();
        foreach ($models as $model) {
            $combs = $model->combinations;
            $sum = 0;
            foreach ($combs as $comb) {
                $sum += $comb->stock;
            }
            $model->updateAttributes(['stock' => $sum]);
        }
    }

    public function actionCheckMu()
    {
        $models = Product::find()->where(['type' => ProductType::TYPE_MATERIAL])->all();
        foreach ($models as $model) {
            if (!$model->save()) {
                echo $model->id . ',';
            }
        }
    }

}
