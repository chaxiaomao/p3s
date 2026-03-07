<?php

namespace backend\modules\P3S\modules\Warehouse\controllers;

use yii\web\Controller;

/**
 * Default controller for the `warehouse` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
