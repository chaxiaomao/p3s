<?php

namespace backend\modules\P3S\modules\Order\modules\OrderItem\controllers;

use common\models\c2\entity\Order;
use cza\base\models\statics\EntityModelStatus;
use Yii;
use common\models\c2\entity\OrderItem;
use common\models\c2\search\OrderItemSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for OrderItem model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\OrderItem';

    /**
     * Lists all OrderItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderItemSearch();
        $queryParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($queryParams);

        $order = Order::findOne($queryParams['OrderItemSearch']['order_id']);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order' => $order,
        ]);
    }

    public function actionStock()
    {
        $request = Yii::$app->request;
        $id = $request->post('id', $request->post('expandRowKey'));

        $orderItems = OrderItem::find()
            ->alias('oi')
            ->select([
                'oi.*',
                'p.stock',
                'o.code',
            ])
            ->leftJoin('c2_product_combination p', 'p.id = oi.combination_id')
            ->leftJoin('c2_order o', 'o.id = oi.order_id')
            ->where(['oi.order_id' => $id])
            ->asArray()
            ->all();

        $comProdIds = ArrayHelper::getColumn($orderItems, 'combination_id');

        $allOrderItems = OrderItem::find()
            ->alias('oi')
            ->select([
                'oi.*',
                'o.code',
            ])
            ->leftJoin('c2_order o', 'o.id = oi.order_id')
            ->where(['in', 'combination_id', $comProdIds])
            // ->andWhere(['oi.status' => EntityModelStatus::STATUS_ACTIVE])
            ->asArray()
            ->all();

        foreach ($orderItems as &$orderItem) {
            foreach ($allOrderItems as $orderItem1) {
                if ($orderItem['combination_id'] == $orderItem1['combination_id']) {
                    $orderItem['other_order_items'][] = $orderItem1;
                }
            }
        }


        return $this->renderAjax('_stock', [
            'models' => $orderItems,
        ]);
    }

    /**
     * Displays a single OrderItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * create/update a OrderItem model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        $model = $this->retrieveModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        return (Yii::$app->request->isAjax) ? $this->renderAjax('edit', ['model' => $model,]) : $this->render('edit', ['model' => $model,]);
    }

    /**
     * Finds the OrderItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return OrderItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
