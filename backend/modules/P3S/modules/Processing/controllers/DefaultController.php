<?php

namespace backend\modules\P3S\modules\Processing\controllers;

use yii\web\Controller;

/**
 * Default controller for the `processing` module
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
