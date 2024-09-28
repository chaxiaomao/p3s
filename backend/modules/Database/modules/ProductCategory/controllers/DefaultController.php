<?php

namespace backend\modules\Database\modules\ProductCategory\controllers;

use backend\models\c2\form\CatProductRsForm;
use common\components\controllers\TreeNodeController;
use cza\base\models\statics\ResponseDatum;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Default controller for the `product-category` module
 */
class DefaultController extends TreeNodeController
{

    protected $_nodeModelClass = 'common\models\c2\entity\ProductCategory';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCatProductRsSave() {
        try {
            // $request = Yii::$app->request;
            $params = Yii::$app->request->post();

            //$entityModel = $this->retrieveModel($params['entity_id']);  //category id
            $formModel = new CatProductRsForm(['entityModel' => \common\models\c2\entity\ProductCategory::findOne($params['entity_id'])]);

            //        if ($request->isPost && Yii::$app->request->isAjax) {
            //            $formModel->load(Yii::$app->request->post());
            //        }

            if ($formModel->save($params['CatProductRsForm'], $params['entity_id'])) {
                // Yii::$app->session->setFlash($formModel->getMessageName(), ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')]));
            } else {
                // Yii::$app->session->setFlash($formModel->getMessageName(), $formModel->errors);
            }

            if (!isset($params['entity_id'])) {
                throw new HttpException(404, Yii::t('cza', "Missing parameter entity_id!"));
            }

            $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')]);
            //return (Yii::$app->request->isAjax) ? $this->renderAjax('_node_hotSale_form', ['model' => $formModel]) : $this->render('edit', ['model' => $formModel->entityModel,]);
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', $ex->getMessage())]);
        }
        // return;
        return $this->asJson($responseData);
    }

}
