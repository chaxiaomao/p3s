<?php

namespace backend\modules\CL\controllers;

use common\helpers\CodeGenerator;
use Yii;
use yii\web\NotFoundHttpException;

use cza\base\components\controllers\backend\ModelController as Controller;

/**
 * Default controller for the `news` module
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index', []);
    }



}
