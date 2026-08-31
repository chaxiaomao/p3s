<?php

namespace backend\controllers;

use backend\models\c2\form\LoginForm;
use common\models\c2\entity\Product;
use common\models\c2\entity\ProductionConsumption;
use common\models\c2\entity\ProductionSchedule;
use common\models\c2\entity\ProductionScheduleItem;
use Yii;
use yii\db\conditions\OrCondition;
use yii\db\Expression;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [
    //                 [
    //                     'actions' => ['login', 'error'],
    //                     'allow' => true,
    //                 ],
    //                 [
    //                     'actions' => ['logout', 'index'],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'logout' => ['post'],
    //             ],
    //         ],
    //     ];
    // }
    //
    // /**
    //  * {@inheritdoc}
    //  */
    // public function actions()
    // {
    //     return [
    //         'error' => [
    //             'class' => 'yii\web\ErrorAction',
    //         ],
    //     ];
    // }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'main-public';
        // print_r(Yii::$app->request->post());
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = Yii::createObject(LoginForm::className());
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            if (!Yii::$app->user->isGuest) {
                return $this->render('500', ['message' => $exception]);
            } else {
                $this->layout = 'main-public';
                return $this->render('error', ['message' => $exception]);
            }
        }
    }

    public function actionFix()
    {


        $rows = ProductionConsumption::find()
            ->alias('pc')
            ->innerJoin(
                ['ps' => ProductionSchedule::tableName()],
                'ps.id = pc.schedule_id'
            )
            ->where(['>', 'ps.created_at', '2026-07-07'])
            ->select([
                'pc.id',
                'pc.schedule_id',
                'pc.schedule_item_id',
                'pc.need_product_id',
                'pc.created_at',
            ])
            ->orderBy([
                'pc.schedule_id' => SORT_ASC,
                'pc.schedule_item_id' => SORT_ASC,
                'pc.need_product_id' => SORT_ASC,
                'pc.created_at' => SORT_ASC,
                'pc.id' => SORT_ASC,
            ])
            ->asArray()
            ->all();


        $groups = [];

        // 按 schedule + item + material 分组
        foreach ($rows as $row) {

            $key = implode('_', [
                $row['schedule_id'],
                $row['schedule_item_id'],
                $row['need_product_id'],
            ]);

            $groups[$key][] = $row;
        }


        $duplicateIds = [];

        foreach ($groups as $key => $items) {

            // 只有一条，肯定不是重复
            if (count($items) <= 1) {
                continue;
            }

            // 获取所有不同的 created_at
            $times = array_values(array_unique(array_column($items, 'created_at')));

            // created_at 全部一样，不认为是重复
            if (count($times) <= 1) {
                continue;
            }

            sort($times);

            $firstTime = $times[0];
            $secondTime = $times[1];

            // 判断两个时间是否刚好相差 1 秒
            $diff = strtotime($secondTime) - strtotime($firstTime);

            if ($diff !== 1) {
                continue;
            }

            // 如果超过两个不同时间，为了安全暂时跳过
            if (count($times) > 2) {
                echo "发现超过两个创建时间，跳过：{$key}\n";
                print_r($items);
                continue;
            }

            echo '<pre>';
            echo "============================\n";
            echo "发现疑似重复请求数据\n";
            echo "schedule_id: {$items[0]['schedule_id']}\n";
            echo "schedule_item_id: {$items[0]['schedule_item_id']}\n";
            echo "need_product_id: {$items[0]['need_product_id']}\n";
            echo "正常时间: {$firstTime}\n";
            echo "重复时间: {$secondTime}\n";

            echo '</pre>';

            foreach ($items as $item) {

                // 只取晚 1 秒生成的数据
                if ($item['created_at'] === $secondTime) {

                    $duplicateIds[] = $item['id'];

                    echo "重复ID: {$item['id']}\n";
                }
            }
        }

        echo "\n\n最终需要处理的重复ID：\n";
        echo implode(',', $duplicateIds);


    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionVans()
    {
        $name = 'PA-123';
        $label = 'PA';
        $nothing = '';

        // $product = Product::find()
        //     ->where([
        //         'or',
        //         ['like', 'name', 'PA'],
        //         ['like', 'name', 'PA'],
        //     ])
        //     ->createCommand()
        //     ->getRawSql();

        // $product = Product::find()
        //     ->where(new OrCondition([
        //         ['like', 'name', 'Pa'],
        //         ['status' => 1]
        //     ]))
        //     ->createCommand()
        //     ->getRawSql();

        $product = Product::find()
            ->where(['status' => 1])
            ->indexBy(function ($row) {
                return $row['id'] .$row['name'];
            })
            // ->orWhere(['like', 'name', 'PA'])
            //     ->filterWhere([
            //         'name' => $name,
            //         'label' => $nothing,
            // ])

            ->createCommand()
            ->getRawSql();

        // $query = (new Query())->select('*')->from('{{%product}}')
        //     ->where('or like', ['name', 'sku'], ['PA'])
        var_dump($product);

    }

}
