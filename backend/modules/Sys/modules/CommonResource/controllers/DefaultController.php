<?php

namespace backend\modules\Sys\modules\CommonResource\controllers;

use yii\web\Controller;

/**
 * Default controller for the `common-resource` module
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
