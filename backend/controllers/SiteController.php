<?php

namespace backend\controllers;

use backend\models\c2\form\LoginForm;
use common\models\c2\entity\Product;
use Yii;
use yii\db\conditions\OrCondition;
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
